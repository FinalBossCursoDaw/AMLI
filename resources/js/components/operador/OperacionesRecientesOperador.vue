<script setup>
import { ref, onMounted } from 'vue';

const operaciones = ref([]);
const cargando = ref(true);
const error = ref(null);

onMounted(async () => {
    try {
        cargando.value = true;
        const response = await fetch('/api/operaciones');
        if (!response.ok) {
            throw new Error('Error al cargar operaciones');
        }
        const todas = await response.json();
        // Mostrar solo las últimas 3 operaciones
        operaciones.value = todas.slice(0, 3);
    } catch (err) {
        error.value = err.message;
        console.error('Error cargando operaciones:', err);
    } finally {
        cargando.value = false;
    }
});

const obtenerClaseEstado = (estado) => {
    const clases = {
        Carrier: 'bg-[#dadde4] text-[#666e79]',
        Seller: 'bg-[#efebec] text-[#7a7476]',
        Buyer: 'bg-[#e8f0f8] text-[#4a6fa5]',
        Vessel: 'bg-[#f0e8f0] text-[#7a5a7a]',
        'En transito': 'bg-[#fff4e6] text-[#8b6914]',
        Entregada: 'bg-[#e8f5e9] text-[#2e7d32]',
    };

    return clases[estado] || 'bg-[#efebec] text-[#6a6566]';
};
</script>

<template>
    <section id="operaciones" class="rounded-lg border border-[#dcd6d8] bg-white shadow-sm">
        <div class="border-b border-[#ebe6e8] px-5 py-3">
            <h2 class="font-montserrat text-[16px] font-semibold text-[#353233]">Operaciones recientes</h2>
        </div>

        <div v-if="error" class="px-5 py-4 text-sm text-red-600">
            Error: {{ error }}
        </div>

        <div v-else-if="cargando" class="px-5 py-4 text-center text-sm text-gray-500">
            Cargando operaciones...
        </div>

        <div v-else-if="operaciones.length === 0" class="px-5 py-4 text-center text-sm text-gray-500">
            No hay operaciones registradas
        </div>

        <div v-else class="overflow-x-auto">
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
