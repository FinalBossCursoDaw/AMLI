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
                    <tr v-if="cargando" class="border-t border-[#efe9eb]">
                        <td colspan="7" class="px-3 py-4 text-center text-[11px] text-[#6a6566]">
                            Cargando ofertas...
                        </td>
                    </tr>

                    <tr v-else-if="ofertas.length === 0" class="border-t border-[#efe9eb]">
                        <td colspan="7" class="px-3 py-4 text-center text-[11px] text-[#6a6566]">
                            No hay ofertas recientes.
                        </td>
                    </tr>

                    <template v-else>
                        <tr
                            v-for="oferta in ofertas"
                            :key="oferta.id"
                            class="border-t border-[#efe9eb] font-montserrat text-[11px] text-[#4a4647]"
                        >
                            <td class="px-3 py-2">{{ oferta.codi_oferta }}</td>
                            <td class="px-3 py-2">{{ oferta.incoterm }}</td>
                            <td class="px-3 py-2">{{ oferta.origen }}</td>
                            <td class="px-3 py-2">{{ oferta.destino }}</td>
                            <td class="px-3 py-2">
                                <span :class="['inline-flex rounded-full px-2 py-0.5 text-[10px] font-semibold', obtenerClaseEstado(oferta.estado)]">
                                    {{ oferta.estado }}
                                </span>
                            </td>
                            <td class="px-3 py-2">{{ oferta.fecha }}</td>
                            <td class="px-3 py-2 text-right">
                                <a :href="`/ofertas/${oferta.id}`" class="rounded bg-[#efebec] px-3 py-1 text-[10px] text-[#686364]">
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
