<template>
  <div class="relative">
    <!-- Pestaña sobrepuesta -->
    <div class="absolute left-0 top-0 z-20 w-96 h-48">
      <Pestana />
    </div>

    <!-- Header -->
    <header class="bg-red-700 relative h-24 z-10">
      <div class="w-full h-full px-8 flex items-center">
        <nav class="flex gap-32 items-center mx-auto font-sans">
          <a href="/register" class="text-white text-2xl font-normal hover:opacity-80 transition-opacity">INICIO</a>
          <a href="/quienes-somos" class="text-white text-2xl font-normal hover:opacity-80 transition-opacity">Quienes somos</a>
          <a href="/contacto" class="text-white text-2xl font-normal hover:opacity-80 transition-opacity">Contacto</a>
        </nav>
      </div>
    </header>
  </div>
</template>

<script setup>
import Pestana from './Pestana.vue';
</script>
