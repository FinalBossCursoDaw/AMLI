# Workflow CI basico

## Proposito

Este proyecto usa un solo workflow de GitHub Actions: `.github/workflows/ci.yml`.

Su objetivo es comprobar lo minimo necesario antes de fusionar cambios: que la app instala dependencias, compila el frontend y pasa los tests.

## Que hace

El workflow ejecuta:

1. Descarga el codigo del repositorio.
2. Instala PHP, Composer y Node.
3. Instala dependencias PHP y frontend.
4. Prepara Laravel.
5. Compila los assets con `npm run build`.
6. Ejecuta PHPUnit.

## Valor aportado

Es un workflow basico y suficiente para saber si el proyecto sigue funcionando.

## Cuando se ejecuta

Se ejecuta automaticamente al hacer `push` o `pull_request` hacia `develop` o `main`.
