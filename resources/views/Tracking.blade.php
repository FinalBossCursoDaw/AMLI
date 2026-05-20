<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tracking - AMLI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app">

        <!--el json_encode sirve para traducir valores php a un formato que entiende el vue-->
        <tracking-operaciones 
        :operacion-id="{{ json_encode($id) }}"
        :cliente ="{{ json_encode($cliente) }}"
        :puerto-origen="{{ json_encode($portOrigen) }}"
        :puerto-destino="{{ json_encode($portDestino) }}"
        ></tracking-operaciones>
    </div>
</body>
</html>
