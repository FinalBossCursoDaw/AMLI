<script setup>
const ofertas = [
    { id: 'OF-2026-001', tipo: 'Import', origen: 'Valencia', destino: 'New York', incoterm: 'FOB', modo: 'Maritimo', estado: 'Espera', contenedor: 'Refrigerado' },
    { id: 'OF-2026-002', tipo: 'Export', origen: 'Madrid', destino: 'Barcelona', incoterm: 'FOB', modo: 'Terrestre', estado: 'Aceptada', contenedor: 'Refrigerado' },
    { id: 'OF-2026-003', tipo: 'Export', origen: 'Melbourne', destino: 'Algeciras', incoterm: 'FOB', modo: 'Aereo', estado: 'Rechazada', contenedor: 'Refrigerado' },
    { id: 'OF-2026-004', tipo: 'Import', origen: 'Rotterdam', destino: 'Bilbao', incoterm: 'FOB', modo: 'Maritimo', estado: 'Borrador', contenedor: 'Refrigerado' },
    { id: 'OF-2026-005', tipo: 'Import', origen: 'Valencia', destino: 'Bangkok', incoterm: 'FOB', modo: 'Maritimo', estado: 'Rechazada', contenedor: 'Refrigerado' },
];

const obtenerClaseEstado = (estado) => {
    const clases = {
        Espera: 'bg-[#f0bf62] text-white',
        Aceptada: 'bg-[#5f8d67] text-white',
        Rechazada: 'bg-[#7f2fff] text-white',
        Borrador: 'bg-[#f22929] text-white',
    };

    return clases[estado] || 'bg-[#e7e1e3] text-[#514d4e]';
};
</script>

<template>
    <section class="rounded-xl border border-[#ddd6d8] bg-white shadow-[0_2px_10px_rgba(0,0,0,0.08)]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[940px]">
                <thead class="bg-[#f5f2f3]">
                    <tr class="font-montserrat text-[10px] uppercase tracking-[0.04em] text-[#b0a8aa]">
                        <th class="px-3 py-3 text-left font-medium">ID</th>
                        <th class="px-3 py-3 text-left font-medium">Tipo</th>
                        <th class="px-3 py-3 text-left font-medium">Origen</th>
                        <th class="px-3 py-3 text-left font-medium">Destino</th>
                        <th class="px-3 py-3 text-left font-medium">Incoterm</th>
                        <th class="px-3 py-3 text-left font-medium">Modo</th>
                        <th class="px-3 py-3 text-left font-medium">Estado actual</th>
                        <th class="px-3 py-3 text-left font-medium">Tipo contenedor</th>
                        <th class="px-3 py-3 text-right font-medium">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="oferta in ofertas"
                        :key="oferta.id"
                        class="border-t border-[#eee8ea] font-montserrat text-[12px] text-[#474344]"
                    >
                        <td class="px-3 py-4">{{ oferta.id }}</td>
                        <td class="px-3 py-4">{{ oferta.tipo }}</td>
                        <td class="px-3 py-4">{{ oferta.origen }}</td>
                        <td class="px-3 py-4">{{ oferta.destino }}</td>
                        <td class="px-3 py-4">{{ oferta.incoterm }}</td>
                        <td class="px-3 py-4">{{ oferta.modo }}</td>
                        <td class="px-3 py-4">
                            <span :class="['inline-flex rounded-full px-2.5 py-1 text-[10px] font-semibold leading-none', obtenerClaseEstado(oferta.estado)]">
                                {{ oferta.estado }}
                            </span>
                        </td>
                        <td class="px-3 py-4">{{ oferta.contenedor }}</td>
                        <td class="px-3 py-4 text-right">
                            <a
                                :href="`/detalle-oferta?id=${oferta.id}`"
                                class="inline-flex rounded-md bg-[#f3eff0] px-3 py-2 text-[12px] text-[#4f4a4b] transition hover:bg-[#e8e1e3]"
                            >
                                Ver
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-col gap-3 border-t border-[#eee8ea] px-3 py-3 font-montserrat text-[11px] text-[#a39ca0] sm:flex-row sm:items-center sm:justify-between">
            <p>Mostrando 1 - 5 de 25 ofertas</p>

            <div class="flex items-center justify-end gap-1 text-[#4f4a4b]">
                <button type="button" class="rounded px-1.5 py-0.5 hover:bg-[#f3eff0]">&lt;</button>
                <button type="button" class="rounded border border-[#dad3d5] px-1.5 py-0.5 bg-[#f8f6f7]">1</button>
                <button type="button" class="rounded border border-[#dad3d5] px-1.5 py-0.5 hover:bg-[#f8f6f7]">2</button>
                <button type="button" class="rounded border border-[#dad3d5] px-1.5 py-0.5 hover:bg-[#f8f6f7]">3</button>
                <button type="button" class="rounded px-1.5 py-0.5 hover:bg-[#f3eff0]">&gt;</button>
            </div>
        </div>
    </section>
</template>
