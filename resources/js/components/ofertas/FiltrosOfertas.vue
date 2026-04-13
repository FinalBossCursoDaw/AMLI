<script setup>
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline';

const filtros = [
    {
        id: 'id',
        etiqueta: 'ID',
        opciones: ['ID', 'OF-2026-001', 'OF-2026-002', 'OF-2026-003'],
    },
    {
        id: 'tipo',
        etiqueta: 'Tipo',
        opciones: ['Tipo', 'Import', 'Export'],
    },
    {
        id: 'origen',
        etiqueta: 'Origen',
        opciones: ['Origen', 'Valencia', 'Madrid', 'Rotterdam', 'Melbourne'],
    },
    {
        id: 'incoterm',
        etiqueta: 'Incoterm',
        opciones: ['Incoterm', 'FOB', 'CIF', 'EXW'],
    },
    {
        id: 'modo',
        etiqueta: 'Modo',
        opciones: ['Modo', 'Maritimo', 'Terrestre', 'Aereo'],
    },
    {
        id: 'estado',
        etiqueta: 'Estado',
        opciones: ['Estado', 'Espera', 'Aceptada', 'Rechazada', 'Borrador'],
    },
];
</script>

<template>
    <section class="rounded-xl border border-[#ddd6d8] bg-white px-5 py-4 shadow-[0_2px_10px_rgba(0,0,0,0.08)]">
        <div class="flex flex-col gap-3 xl:flex-row xl:flex-wrap xl:items-center">
            <select
                v-for="filtro in filtros"
                :key="filtro.id"
                class="h-10 rounded-md border border-[#ebe6e8] bg-[#f6f4f5] px-3 font-montserrat text-[13px] text-[#4e4a4b] outline-none transition focus:border-[#cfb8bb]"
            >
                <option
                    v-for="opcion in filtro.opciones"
                    :key="opcion"
                >
                    {{ opcion }}
                </option>
            </select>

            <div class="flex h-10 min-w-[220px] items-center gap-2 rounded-md border border-[#ebe6e8] bg-[#f6f4f5] px-3 xl:flex-1">
                <MagnifyingGlassIcon class="h-4 w-4 text-[#222222]" />
                <input
                    type="text"
                    placeholder="Buscar"
                    class="w-full bg-transparent font-montserrat text-[13px] text-[#4e4a4b] outline-none placeholder:text-[#4e4a4b]"
                />
            </div>
        </div>
    </section>
</template>
