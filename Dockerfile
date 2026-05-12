# syntax=docker/dockerfile:1

# Etapa 1: instala las dependencias PHP con Composer.
# Se hace en una etapa separada para copiar solo la carpeta vendor a la imagen final.
FROM composer:2 AS vendor
WORKDIR /app

# Primero se copian solo los ficheros de Composer para aprovechar la cache de Docker.
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --prefer-dist

COPY app ./app
COPY bootstrap ./bootstrap
COPY config ./config
COPY database ./database
COPY routes ./routes
COPY artisan ./

# Optimiza el autoload para produccion.
RUN composer dump-autoload \
    --no-dev \
    --classmap-authoritative \
    --optimize

# Etapa 2: compila los assets del frontend con Node.
# El resultado queda en public/build y se copia despues a la imagen final.
FROM node:22-alpine AS frontend
WORKDIR /app

# Se instalan dependencias con npm ci para usar exactamente package-lock.json.
COPY package.json package-lock.json ./
RUN npm ci

# Se copian solo los ficheros necesarios para generar el build de Vite.
COPY resources ./resources
COPY public ./public
COPY components.json ./
COPY tailwind.config.js ./
COPY tsconfig.json ./
COPY vite.config.ts ./

RUN npm run build

# Etapa 3: imagen final de la aplicacion.
# Usa PHP con Apache y sirve Laravel desde public/.
FROM php:8.3-apache AS app

ENV ACCEPT_EULA=Y
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Instala librerias del sistema y el driver ODBC de Microsoft para SQL Server.
RUN set -eux; \
    microsoft_arch="$(dpkg --print-architecture)"; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        ca-certificates \
        curl \
        gnupg \
        libgssapi-krb5-2 \
        libicu-dev \
        libonig-dev \
        libxml2-dev \
        libzip-dev \
        unixodbc \
        unixodbc-dev \
        zip \
        $PHPIZE_DEPS; \
    curl -fsSL https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor -o /usr/share/keyrings/microsoft-prod.gpg; \
    echo "deb [arch=${microsoft_arch} signed-by=/usr/share/keyrings/microsoft-prod.gpg] https://packages.microsoft.com/debian/12/prod bookworm main" > /etc/apt/sources.list.d/microsoft.list; \
    apt-get update; \
    ACCEPT_EULA=Y apt-get install -y --no-install-recommends msodbcsql18; \
    rm -rf /var/lib/apt/lists/*

# Instala extensiones PHP necesarias para Laravel y SQL Server.
RUN docker-php-ext-install bcmath intl mbstring opcache zip \
    && pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv

# Activa rewrite y cambia el DocumentRoot de Apache a /public.
RUN a2enmod rewrite \
    && sed -ri "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/000-default.conf /etc/apache2/apache2.conf \
    && rm -rf /tmp/pear

WORKDIR /var/www/html

# Copia el codigo de la aplicacion.
COPY . .

# Copia las dependencias PHP y los assets compilados desde las etapas anteriores.
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

# Prepara Laravel: descubre paquetes, crea carpetas necesarias y ajusta permisos.
RUN cp .env.example .env \
    && rm -f bootstrap/cache/packages.php bootstrap/cache/services.php \
    && php artisan package:discover --ansi \
    && rm .env \
    && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

# Arranca Apache en primer plano, que es lo que Docker necesita para mantener el contenedor vivo.
CMD ["apache2-foreground"]
