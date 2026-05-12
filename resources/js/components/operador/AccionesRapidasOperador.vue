<script setup>
import { PlusIcon } from '@heroicons/vue/24/outline';
</script>

<template>
    <section class="overflow-hidden rounded-lg border border-[#d8d1d3] bg-white shadow-[0_14px_32px_rgba(48,48,48,0.08)]">
        <div class="border-b border-[#ebe6e8] bg-[#fffdfd] px-5 py-3">
            <h2 class="font-montserrat text-[16px] font-semibold text-[#353233]">Acciones rapidas</h2>
        </div>

        <div class="grid gap-4 p-5 sm:grid-cols-2">
            <a
                href="/ofertas/crear"
                class="group flex items-center justify-between rounded-lg border border-[#ece7e8] bg-[#fcfbfb] px-4 py-4 shadow-sm transition hover:-translate-y-0.5 hover:border-[#f0b3b5] hover:bg-white hover:shadow-[0_14px_24px_rgba(201,23,29,0.12)]"
            >
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-[#ff1f1f] text-white shadow-[0_10px_18px_rgba(255,31,31,0.28)] transition group-hover:scale-105">
                        <PlusIcon class="h-7 w-7" />
                    </div>
                    <span class="font-montserrat text-[18px] font-medium text-[#353233]">Crear oferta</span>
                </div>
                <span class="text-[22px] text-[#c9171d] transition group-hover:translate-x-1">></span>
            </a>

            <a
                href="/anadir-cliente"
                class="group flex items-center justify-between rounded-lg border border-[#ece7e8] bg-[#fcfbfb] px-4 py-4 shadow-sm transition hover:-translate-y-0.5 hover:border-[#f2d59a] hover:bg-white hover:shadow-[0_14px_24px_rgba(241,182,69,0.14)]"
            >
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-[#f3b649] shadow-[0_10px_18px_rgba(243,182,73,0.26)] transition group-hover:scale-105">
                        <img src="/imagenes/cliente.png" alt="Crear cliente" class="h-6 w-6 object-contain" />
                    </div>
                    <span class="font-montserrat text-[18px] font-medium text-[#353233]">Crear cliente</span>
                </div>
                <span class="text-[22px] text-[#c9171d] transition group-hover:translate-x-1">></span>
            </a>
        </div>
    </section>
</template>
