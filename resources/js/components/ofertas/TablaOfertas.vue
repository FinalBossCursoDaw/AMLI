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
        class="border-t border-[#eee8ea] font-montserrat text-[12px] text-[#474344]"
    >
        <td class="px-3 py-4">{{ oferta.codi_oferta }}</td>
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
                :href="`/ofertas/${oferta.id}`"
                class="inline-flex rounded-md bg-[#f3eff0] px-3 py-2 text-[12px] text-[#4f4a4b] transition hover:bg-[#e8e1e3]"
            >
                Ver
            </a>
        </td>
    </tr>
</tbody>

            </table>
        </div>

        <div class="border-t border-[#eee8ea] px-3 py-3 font-montserrat text-[11px] text-[#a39ca0]">
            <p>Mostrando {{ ofertas.length }} ofertas</p>
        </div>
    </section>
</template>