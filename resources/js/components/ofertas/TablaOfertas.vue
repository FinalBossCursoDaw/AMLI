<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';

const ofertas = ref([]);
const cargando = ref(true);
const error = ref('');


const obtenerClaseEstado = (estado) => {
    const clases = {
        Espera: 'bg-[#f0bf62] text-white',
        Aceptada: 'bg-[#5f8d67] text-white',
        Rechazada: 'bg-[#7f2fff] text-white',
        Borrador: 'bg-[#f22929] text-white',
    };

    return clases[estado] || 'bg-[#e7e1e3] text-[#514d4e]';
};

const cargarOfertas = async () => {
    try {
        cargando.value = true;
        error.value = '';

        const response = await axios.get('/api/ofertas');
        ofertas.value = response.data;
    } catch (err) {
        console.error('Error cargando ofertas:', err);
        error.value = 'No se han podido cargar las ofertas.';
        ofertas.value = [];
    } finally {
        cargando.value = false;
    }
};


onMounted(() => {
    cargarOfertas();
});
</script>


<template>
    <section class="amli-panel">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[940px]">
                <thead class="amli-table-head">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">ID</th>
                        <th class="px-4 py-3 text-left font-semibold">Tipo</th>
                        <th class="px-4 py-3 text-left font-semibold">Origen</th>
                        <th class="px-4 py-3 text-left font-semibold">Destino</th>
                        <th class="px-4 py-3 text-left font-semibold">Incoterm</th>
                        <th class="px-4 py-3 text-left font-semibold">Modo</th>
                        <th class="px-4 py-3 text-left font-semibold">Estado actual</th>
                        <th class="px-4 py-3 text-left font-semibold">Tipo contenedor</th>
                        <th class="px-4 py-3 text-right font-semibold">Accion</th>
                    </tr>
                </thead>
                <tbody>
    <tr v-if="cargando" class="border-t border-[#eee8ea] font-montserrat text-[12px] text-[#474344]">
        <td colspan="9" class="px-3 py-4 text-center">
            Cargando ofertas...
        </td>
    </tr>
    <tr v-else-if="error" class="border-t border-[#eee8ea] font-montserrat text-[12px] text-[#474344]">
        <td colspan="9" class="px-3 py-4 text-center">
            {{ error }}
        </td>
    </tr>

    <tr v-else-if="ofertas.length === 0" class="border-t border-[#eee8ea] font-montserrat text-[12px] text-[#474344]">
        <td colspan="9" class="px-3 py-4 text-center">
            No hay ofertas disponibles.
        </td>
    </tr>

    <tr
        v-else
        v-for="oferta in ofertas"
        :key="oferta.id"
        class="amli-table-row"
    >
        <td class="px-4 py-4 font-semibold text-[#353233]">{{ oferta.codi_oferta }}</td>
        <td class="px-4 py-4">{{ oferta.tipo }}</td>
        <td class="px-4 py-4">{{ oferta.origen }}</td>
        <td class="px-4 py-4">{{ oferta.destino }}</td>
        <td class="px-4 py-4">{{ oferta.incoterm }}</td>
        <td class="px-4 py-4">{{ oferta.modo }}</td>
        <td class="px-4 py-4">
            <span :class="['inline-flex rounded-full px-2.5 py-1 text-[10px] font-semibold leading-none', obtenerClaseEstado(oferta.estado)]">
                {{ oferta.estado }}
            </span>
        </td>
        <td class="px-4 py-4">{{ oferta.contenedor }}</td>
        <td class="px-4 py-4 text-right">
            <a
                :href="`/ofertas/${oferta.id}`"
                class="inline-flex rounded-md border border-[#e6dedf] bg-[#f8f4f5] px-3 py-2 text-[12px] font-semibold text-[#4f4a4b] transition hover:border-[#c9171d] hover:bg-[#c9171d] hover:text-white"
            >
                Ver
            </a>
        </td>
    </tr>
</tbody>

            </table>
        </div>

        <div class="border-t border-[#eee8ea] bg-[#fffdfd] px-4 py-3 font-montserrat text-[11px] text-[#8e8588]">
            <p>Mostrando {{ ofertas.length }} ofertas</p>
        </div>
    </section>
</template>
