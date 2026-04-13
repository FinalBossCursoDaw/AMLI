<script setup>
const operaciones = [
    { id: 'OP-00056', cliente: 'Textil BCN S.L.', tipo: 'Exportacion', incoterm: 'FOB', estado: 'Carrier' },
    { id: 'OP-00042', cliente: 'ElectroNova S.A.', tipo: 'Importacion', incoterm: 'CIF', estado: 'Seller' },
    { id: 'OP-00012', cliente: 'Maritim Foods', tipo: 'Exportacion', incoterm: 'EXW', estado: 'Carrier' },
];

const obtenerClaseEstado = (estado) => {
    const clases = {
        Carrier: 'bg-[#dadde4] text-[#666e79]',
        Seller: 'bg-[#efebec] text-[#7a7476]',
    };

    return clases[estado] || 'bg-[#efebec] text-[#6a6566]';
};
</script>

<template>
    <section id="operaciones" class="rounded-lg border border-[#dcd6d8] bg-white shadow-sm">
        <div class="border-b border-[#ebe6e8] px-5 py-3">
            <h2 class="font-montserrat text-[16px] font-semibold text-[#353233]">Operaciones recientes</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#f8f6f7]">
                    <tr class="font-montserrat text-[10px] uppercase tracking-[0.04em] text-[#b4adaf]">
                        <th class="px-3 py-2 text-left font-medium">ID</th>
                        <th class="px-3 py-2 text-left font-medium">Cliente</th>
                        <th class="px-3 py-2 text-left font-medium">Tipo</th>
                        <th class="px-3 py-2 text-left font-medium">Incoterm</th>
                        <th class="px-3 py-2 text-left font-medium">Estado</th>
                        <th class="px-3 py-2 text-right font-medium">Accion</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="operacion in operaciones"
                        :key="operacion.id"
                        class="border-t border-[#efe9eb] font-montserrat text-[11px] text-[#4a4647]"
                    >
                        <td class="px-3 py-2">{{ operacion.id }}</td>
                        <td class="px-3 py-2">{{ operacion.cliente }}</td>
                        <td class="px-3 py-2">{{ operacion.tipo }}</td>
                        <td class="px-3 py-2">{{ operacion.incoterm }}</td>
                        <td class="px-3 py-2">
                            <span :class="['inline-flex rounded-full px-2 py-0.5 text-[10px] font-semibold', obtenerClaseEstado(operacion.estado)]">
                                {{ operacion.estado }}
                            </span>
                        </td>
                        <td class="px-3 py-2 text-right">
                            <a href="#" class="rounded bg-[#efebec] px-3 py-1 text-[10px] text-[#686364]">Ver</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</template>
