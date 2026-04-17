#!/bin/sh
set -eu

HOT_FILE="/var/www/html/public/hot"
CACHE_DIR="/var/www/html/bootstrap/cache"

rm -f "$CACHE_DIR/packages.php" "$CACHE_DIR/services.php"
php artisan package:discover --ansi >/dev/null

if [ -f "$HOT_FILE" ]; then
    HOT_URL="$(tr -d '\r\n' < "$HOT_FILE")"
    CHECK_URL="$HOT_URL"
    HOST_HEADER=""

    case "$HOT_URL" in
        http://localhost:*|https://localhost:*|http://127.0.0.1:*|https://127.0.0.1:*)
            CHECK_URL="$(printf '%s' "$HOT_URL" | sed -E 's#(https?://)(localhost|127\.0\.0\.1)(:.*)?#\1vite\3#')"
            HOST_HEADER="$(printf '%s' "$HOT_URL" | sed -E 's#https?://##')"
            ;;
    esac

    STATUS_CODE="$(
        if [ -n "$HOST_HEADER" ]; then
            curl -sS -o /dev/null -w '%{http_code}' --max-time 2 -H "Host: $HOST_HEADER" "$CHECK_URL/@vite/client" || true
        else
            curl -sS -o /dev/null -w '%{http_code}' --max-time 2 "$CHECK_URL/@vite/client" || true
        fi
    )"

    if [ -z "$HOT_URL" ] || [ "$STATUS_CODE" = "000" ] || [ -z "$STATUS_CODE" ]; then
        echo "Vite dev server is not reachable. Falling back to compiled assets."
        rm -f "$HOT_FILE"
    fi
fi

exec apache2-foreground
