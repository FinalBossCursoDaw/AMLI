<script setup>
import { ArrowUpTrayIcon, ClipboardDocumentListIcon } from '@heroicons/vue/24/outline';

const ofertasEnviadas = 4;
const operacionesEnCurso = 5;
</script>

<template>
    <div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div class="flex flex-wrap gap-4">
            <div class="flex min-w-[160px] items-center gap-3 rounded-lg border border-[#ded8da] bg-white px-4 py-3 shadow-sm">
                <div class="text-[24px] text-[#f0ab33]">X</div>
                <div>
                    <p class="font-montserrat text-[11px] font-semibold text-[#474344]">Ofertas enviadas</p>
                    <p class="font-montserrat text-[26px] leading-none text-[#f0ab33]">{{ ofertasEnviadas }}</p>
                </div>
            </div>

            <div class="flex min-w-[170px] items-center gap-3 rounded-lg border border-[#ded8da] bg-white px-4 py-3 shadow-sm">
                <div class="text-[#5b8a61]">
                    <ClipboardDocumentListIcon class="h-7 w-7" />
                </div>
                <div>
                    <p class="font-montserrat text-[11px] font-semibold text-[#474344]">Operaciones en curso</p>
                    <p class="font-montserrat text-[26px] leading-none text-[#5b8a61]">{{ operacionesEnCurso }}</p>
                </div>
            </div>
        </div>

        <button
            type="button"
            class="inline-flex items-center gap-2 rounded-lg border border-[#ddd7d9] bg-white px-4 py-3 font-montserrat text-[12px] font-medium text-[#5f5a5b] shadow-sm transition hover:bg-[#faf8f9]"
        >
            <ArrowUpTrayIcon class="h-4 w-4 text-[#5f5a5b]" />
            Subir archivo
        </button>
    </div>
</template>
