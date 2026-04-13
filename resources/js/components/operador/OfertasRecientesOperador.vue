<script setup>
const ofertas = [
    { id: 'ITU0041', tipo: 'FOB', origen: 'Barcelona - Marruecos', destino: 'Barcelona', estado: 'Espera', fecha: '16/11/2025' },
    { id: 'ITU0047', tipo: 'CIF', origen: 'Barcelona - Bali', destino: 'Bali', estado: 'Aceptada', fecha: '11/11/2025' },
    { id: 'ITU0142', tipo: 'EX WORKS', origen: 'Barcelona - Islandia', destino: 'Islandia', estado: 'Rechazada', fecha: '07/11/2025' },
    { id: 'ITU0021', tipo: 'CIF', origen: 'Barcelona - Santorini', destino: 'Santorini', estado: 'Borrador', fecha: '11/11/2025' },
];

const obtenerClaseEstado = (estado) => {
    const clases = {
        Espera: 'bg-[#ffd96d] text-[#7e5f00]',
        Aceptada: 'bg-[#8fdb98] text-[#1f6d2d]',
        Rechazada: 'bg-[#ff9696] text-[#8b1f1f]',
        Borrador: 'bg-[#ff4747] text-white',
    };

    return clases[estado] || 'bg-[#efebec] text-[#6a6566]';
};
</script>

<template>
    <section id="ofertas" class="rounded-lg border border-[#dcd6d8] bg-white shadow-sm">
        <div class="border-b border-[#ebe6e8] px-5 py-3">
            <h2 class="font-montserrat text-[16px] font-semibold text-[#353233]">Ofertas recientes</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#f8f6f7]">
                    <tr class="font-montserrat text-[10px] uppercase tracking-[0.04em] text-[#b4adaf]">
                        <th class="px-3 py-2 text-left font-medium">N oferta</th>
                        <th class="px-3 py-2 text-left font-medium">Incoterms</th>
                        <th class="px-3 py-2 text-left font-medium">Origen</th>
                        <th class="px-3 py-2 text-left font-medium">Destino</th>
                        <th class="px-3 py-2 text-left font-medium">Estado</th>
                        <th class="px-3 py-2 text-left font-medium">Fecha</th>
                        <th class="px-3 py-2 text-right font-medium">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="oferta in ofertas"
                        :key="oferta.id"
                        class="border-t border-[#efe9eb] font-montserrat text-[11px] text-[#4a4647]"
                    >
                        <td class="px-3 py-2">{{ oferta.id }}</td>
                        <td class="px-3 py-2">{{ oferta.tipo }}</td>
                        <td class="px-3 py-2">{{ oferta.origen }}</td>
                        <td class="px-3 py-2">{{ oferta.destino }}</td>
                        <td class="px-3 py-2">
                            <span :class="['inline-flex rounded-full px-2 py-0.5 text-[10px] font-semibold', obtenerClaseEstado(oferta.estado)]">
                                {{ oferta.estado }}
                            </span>
                        </td>
                        <td class="px-3 py-2">{{ oferta.fecha }}</td>
                        <td class="px-3 py-2 text-right">
                            <a href="#" class="rounded bg-[#efebec] px-3 py-1 text-[10px] text-[#686364]">Ver</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>
