# Flux personalitzat: validacio Docker

## Proposta

El tercer flux comprova que la configuracio Docker del projecte funciona abans de fusionar canvis a `develop` o `main`.

## Que fa

El fitxer `.github/workflows/custom-flow.yml` executa:

1. Copia `.env.example` a `.env` per poder validar la configuracio.
2. Executa `docker compose config`.
3. Construeix la imatge amb `docker build -t amli-app .`.

## Valor aportat

Detecta errors basics del `Dockerfile` o del `docker-compose.yml` abans que arribin a la branca principal.

## Demostracio

Es pot demostrar obrint una pull request o executant-lo manualment des de `Actions > custom-flow > Run workflow`.
