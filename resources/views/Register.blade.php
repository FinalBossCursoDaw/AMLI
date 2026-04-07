<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro - AMLI</title>

    <!-- Google Fonts - Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <main class="min-h-screen bg-[#f3f1f3]">
        <section class="flex min-h-screen w-full">
            <div class="relative min-h-screen w-full overflow-hidden bg-[#f3f1f3]">
                <img
                    alt=""
                    aria-hidden="true"
                    class="pointer-events-none absolute right-[320px] top-[-70px] z-0 h-[calc(100%+70px)] w-[380px] max-w-none select-none sm:right-[620px] sm:w-[500px] lg:right-[980px] lg:w-[620px]"
                    src="/imagenes/rayas.png"
                />

                <div
                    class="absolute right-[220px] top-1/2 z-20 hidden h-[560px] w-[420px] -translate-y-1/2 rounded-[22px] border border-[#e6dfdf] bg-white shadow-[0_8px_20px_rgba(0,0,0,0.18)] lg:block xl:right-[320px] xl:h-[590px] xl:w-[450px]"
                ></div>


                <div class="relative z-10 ml-16 mt-8 max-w-[520px] sm:ml-24 sm:mt-12 lg:ml-32">
                    <p
                        class="font-montserrat text-[clamp(2.5rem,5.1vw,4.25rem)] font-medium leading-none tracking-[-0.04em] text-[#111111]">
                        Accede a
                    </p>

                    <h1
                        class="mt-2 relative font-montserrat text-[clamp(3rem,4.5vw,5rem)] font-bold leading-none tracking-[-0.05em] text-[#cb0c14]">
                        AMLI
                    </h1>

                    <div class="mt-4 relative h-1 w-28 bg-[#cb0c14] sm:w-36 lg:mt-5 lg:w-40"></div>

                    <p
                        class="mt-6 max-w-[28ch] font-montserrat text-[clamp(1.25rem,2.25vw,2.15rem)] leading-[1.18] text-[#121212] lg:mt-7">
                        Gestiona ofertas, operaciones y seguimiento
                        <span class="font-semibold">en un solo lugar</span>
                    </p>
                </div>

                <div class="relative mt-40 flex items-end justify-center sm:mt-44 lg:justify-start">
                    <img alt="Camion de AMLI Logistics"
                        class="pointer-events-none relative z-10 w-[720px] max-w-[140%] translate-x-8 select-none drop-shadow-[0_24px_30px_rgba(0,0,0,0.2)] sm:w-[880px] sm:max-w-[125%] sm:translate-x-12 lg:w-[1040px] lg:max-w-none lg:translate-x-16"
                        src="/imagenes/caminion.png" />
                </div>
            </div>
        </section>
    </main>
    </div>
</body>
</html>
