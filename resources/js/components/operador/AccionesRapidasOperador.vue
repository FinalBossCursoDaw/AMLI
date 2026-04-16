<script setup>
import { PlusIcon } from '@heroicons/vue/24/outline';
</script>

<template>
    <section class="rounded-lg border border-[#dcd6d8] bg-white shadow-sm">
        <div class="border-b border-[#ebe6e8] px-5 py-3">
            <h2 class="font-montserrat text-[16px] font-semibold text-[#353233]">Acciones rapidas</h2>
        </div>

        <div class="grid gap-4 p-5 sm:grid-cols-2">
            <a
                href="/ofertas/crear"
                class="flex items-center justify-between rounded-lg border border-[#ece7e8] bg-[#fcfbfb] px-4 py-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
            >
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-[#ff1f1f] text-white">
                        <PlusIcon class="h-7 w-7" />
                    </div>
                    <span class="font-montserrat text-[18px] font-medium text-[#353233]">Crear oferta</span>
                </div>
                <span class="text-[22px] text-[#353233]">></span>
            </a>

            <a
                href="/anadir-cliente"
                class="flex items-center justify-between rounded-lg border border-[#ece7e8] bg-[#fcfbfb] px-4 py-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
            >
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-[#f3b649]">
                        <img src="/imagenes/cliente.png" alt="Crear cliente" class="h-6 w-6 object-contain" />
                    </div>
                    <span class="font-montserrat text-[18px] font-medium text-[#353233]">Crear cliente</span>
                </div>
                <span class="text-[22px] text-[#353233]">></span>
            </a>
        </div>
    </section>
</template>
