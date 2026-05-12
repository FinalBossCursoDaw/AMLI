<script setup lang="ts">
</script>

<template>
    <div class="amli-page">
        <header-component></header-component>

        <div class="mx-auto mt-8 max-w-5xl px-6 py-10 text-center">
            <h2 class="font-montserrat text-4xl font-normal leading-tight text-[#303030]">
                ¿Tienes alguna pregunta o necesitas <span class="font-semibold">ayuda</span>? Ponte en contacto con nosotros
            </h2>
        </div>

        <cajas-contacto></cajas-contacto>
        <info-adicional></info-adicional>

        <div class="mx-auto flex max-w-[1200px] items-center justify-between px-16 py-10">
            <div class="flex flex-col items-start">
                <h2 class="mb-8 font-montserrat text-4xl font-semibold text-[#303030]">
                    ¿Ya formas parte de AMLI?
                </h2>
                <boton-degradado text="Iniciar Sesión" :show-arrow="false" href="/register"></boton-degradado>
            </div>

            <div class="flex items-center">
                <img src="/imagenes/caminion.png" alt="Camión AMLI" class="h-64 w-auto object-contain drop-shadow-[0_18px_24px_rgba(48,48,48,0.18)]">
            </div>
        </div>
    </div>
</template>
