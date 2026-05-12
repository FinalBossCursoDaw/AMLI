<script setup>
import axios from 'axios';
import { onMounted, ref } from 'vue';

const ofertas = ref([]);
const cargando = ref(true);

const incoterms = ref([]);
const puertos = ref([]);
const aeropuertos = ref([]);

const estados = {
    1: 'Borrador',
    2: 'Espera',
    3: 'Aceptada',
    4: 'Rechazada',
};

const obtenerIncoterm = (id) => {
    for (const item of incoterms.value) {
        if (String(item.id) === String(id)) {
            return item.codi;
        }
    }

    return '-';
};

const obtenerLugar = (portId, airportId) => {
    for (const item of puertos.value) {
        if (String(item.id) === String(portId)) {
            return item.nom;
        }
    }

    for (const item of aeropuertos.value) {
        if (String(item.id) === String(airportId)) {
            return item.nom;
        }
    }

    return '-';
};

const formatearFecha = (fecha) => {
    if (!fecha) {
        return '-';
    }

    const partes = fecha.split('-');

    if (partes.length !== 3) {
        return fecha;
    }

    return `${partes[2]}/${partes[1]}/${partes[0]}`;
};

const obtenerClaseEstado = (estado) => {
    const clases = {
        Espera: 'bg-[#ffd96d] text-[#7e5f00]',
        Aceptada: 'bg-[#8fdb98] text-[#1f6d2d]',
        Rechazada: 'bg-[#ff9696] text-[#8b1f1f]',
        Borrador: 'bg-[#ff4747] text-white',
    };

    return clases[estado] || 'bg-[#efebec] text-[#6a6566]';
};

const cargarOfertas = async () => {
    try {
        cargando.value = true;

        const opcionesResponse = await axios.get('/api/ofertas/formulario');
        incoterms.value = opcionesResponse.data.incoterms ?? [];
        puertos.value = opcionesResponse.data.ports ?? [];
        aeropuertos.value = opcionesResponse.data.aeroports ?? [];

        const ofertasResponse = await axios.get('/api/ofertas/recientes');

        ofertas.value = ofertasResponse.data.map((oferta) => {
            return {
                id: oferta.id,
                codi_oferta: oferta.codi_oferta,
                incoterm: obtenerIncoterm(oferta.incoterm_id),
                origen: obtenerLugar(oferta.port_origen_id, oferta.aeroport_origen_id),
                destino: obtenerLugar(oferta.port_desti_id, oferta.aeroport_desti_id),
                estado: estados[oferta.estat_oferta_id] ?? 'Sin estado',
                fecha: formatearFecha(oferta.data_creacio),
            };
        });
    } catch (error) {
        console.error('Error cargando ofertas recientes:', error);
    } finally {
        cargando.value = false;
    }
};

onMounted(() => {
    cargarOfertas();
});
</script>

<template>
    <section id="ofertas" class="overflow-hidden rounded-lg border border-[#d8d1d3] bg-white shadow-[0_14px_32px_rgba(48,48,48,0.08)]">
        <div class="border-b border-[#ebe6e8] bg-[#fffdfd] px-5 py-3">
            <h2 class="font-montserrat text-[16px] font-semibold text-[#353233]">Ofertas recientes</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#f8f6f7]">
                    <tr class="font-montserrat text-[10px] uppercase tracking-[0.06em] text-[#9f9699]">
                        <th class="px-4 py-3 text-left font-semibold">N oferta</th>
                        <th class="px-4 py-3 text-left font-semibold">Incoterms</th>
                        <th class="px-4 py-3 text-left font-semibold">Origen</th>
                        <th class="px-4 py-3 text-left font-semibold">Destino</th>
                        <th class="px-4 py-3 text-left font-semibold">Estado</th>
                        <th class="px-4 py-3 text-left font-semibold">Fecha</th>
                        <th class="px-4 py-3 text-right font-semibold">Accion</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-if="cargando" class="border-t border-[#efe9eb]">
                        <td colspan="7" class="px-4 py-5 text-center text-[12px] text-[#6a6566]">
                            Cargando ofertas...
                        </td>
                    </tr>

                    <tr v-else-if="ofertas.length === 0" class="border-t border-[#efe9eb]">
                        <td colspan="7" class="px-4 py-5 text-center text-[12px] text-[#6a6566]">
                            No hay ofertas recientes.
                        </td>
                    </tr>

                    <template v-else>
                        <tr
                            v-for="oferta in ofertas"
                            :key="oferta.id"
                            class="border-t border-[#efe9eb] font-montserrat text-[12px] text-[#4a4647] transition hover:bg-[#fff8f8]"
                        >
                            <td class="px-4 py-3 font-semibold text-[#353233]">{{ oferta.codi_oferta }}</td>
                            <td class="px-4 py-3">{{ oferta.incoterm }}</td>
                            <td class="px-4 py-3">{{ oferta.origen }}</td>
                            <td class="px-4 py-3">{{ oferta.destino }}</td>
                            <td class="px-4 py-3">
                                <span :class="['inline-flex rounded-full px-2 py-0.5 text-[10px] font-semibold', obtenerClaseEstado(oferta.estado)]">
                                    {{ oferta.estado }}
                                </span>
                            </td>
                            <td class="px-4 py-3">{{ oferta.fecha }}</td>
                            <td class="px-4 py-3 text-right">
                                <a :href="`/ofertas/${oferta.id}`" class="rounded-md border border-[#e6dedf] bg-[#f8f4f5] px-3 py-1.5 text-[10px] font-semibold text-[#686364] transition hover:border-[#c9171d] hover:bg-[#c9171d] hover:text-white">
                                    Ver
                                </a>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </section>
</template>
