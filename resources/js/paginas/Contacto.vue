<script setup lang="ts">
</script>

<template>
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
                <boton-degradado text="Iniciar Sesión" :show-arrow="false" href="/register"></boton-degradado>
            </div>

            <div class="flex items-center">
                <img src="/imagenes/caminion.png" alt="Camión AMLI" class="w-auto h-64 object-contain">
            </div>
        </div>
    </div>
</template>
