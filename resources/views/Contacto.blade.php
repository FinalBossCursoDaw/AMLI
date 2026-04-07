<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Contacto - AMLI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background-color: #F3F1F3; margin: 0; padding: 0;">
    <div id="app">
        <div>
            <header-component></header-component>

            <div class="text-center py-8 mt-8">
                <h2 class="font-normal text-gray-800" style="font-size:2rem; line-height: 1.2;">
                    ¿Tienes alguna pregunta o necesitas <span class="font-semibold">ayuda</span>? Ponte en contacto con nosotros
                </h2>
            </div>

            <cajas-contacto></cajas-contacto>
            <info-adicional></info-adicional>

            <div class="flex justify-between items-center px-16 py-8 max-w-full mx-auto" style="max-width: 1400px;">
                <div class="flex flex-col items-start">
                    <h2 class="text-4xl font-semibold text-gray-800 mb-8">
                        ¿Ya formas parte de AMLI?
                    </h2>
                    <a href="/register" class="bg-red-600 text-white px-20 py-4 rounded-lg text-xl font-semibold hover:bg-red-700 transition-colors">
                        Iniciar Sesión
                    </a>
                </div>

                <div class="flex items-center">
                    <img src="/imagenes/caminion.png" alt="Camión AMLI" class="w-auto h-64 object-contain">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
