<script setup>
import { ChevronRightIcon, ClipboardDocumentListIcon, FolderIcon } from '@heroicons/vue/24/outline';
import { computed, onMounted, ref } from 'vue';
import axios from 'axios';
import HeaderRegistrado from '../components/Header-registrado.vue';
import NavIzquierda from '../components/Navizquierda.vue';

const props = defineProps({
    ofertaId: {
        type: String,
        default: '',
    },
    rolId: {
        type: Number,
        default: 0,
    },
});

const menuOperativo = computed(() => {
    const items = [
        { id: 'dashboard', label: 'Dashboard', icon: '/imagenes/casita.png', path: '/dashboard-operador-cliente', iconType: 'image' },
        { id: 'ofertas', label: 'Ofertas', icon: '', path: '/ofertas', iconType: 'component', iconComponent: ClipboardDocumentListIcon },
        { id: 'operaciones', label: 'Operaciones', icon: '', path: '/operaciones', iconType: 'component', iconComponent: FolderIcon },
    ];

    if (props.rolId === 2) {
        items.splice(1, 0, {
            id: 'clientes',
            label: 'Clientes',
            icon: '/imagenes/cliente.png',
            path: '/dashboard-admin',
            iconType: 'image',
        });
    }

    return items;
});

const cargando = ref(true);
const procesando = ref(false);
const error = ref('');

const estadoTexto = {
    1: 'Borrador',
    2: 'Espera',
    3: 'Aceptada',
    4: 'Rechazada',
};

const tipoFlujoTexto = {
    1: 'Importacion',
    2: 'Exportacion',
};

const tipoTransporteTexto = {
    1: 'Maritimo',
    2: 'Aereo',
    3: 'Terrestre',
};

const tipoCargaTexto = {
    1: 'FCL',
    2: 'LCL',
};

const oferta = ref({
    id: '',
    estado: 'Espera',
    validez: '-',
    cliente: '-',
    tipo: '-',
    incoterm: '-',
    transporte: '-',
    origen: '-',
    destino: '-',
    shippingLine: '-',
    peso: '-',
    cbm: '-',
    modalidad: '-',
    contenedor: '-',
    tamano: '-',
    descripcion: '-',
});

const estadoClasses = {
    Espera: 'bg-[#f0bf62] text-white',
    Aceptada: 'bg-[#5f8d67] text-white',
    Rechazada: 'bg-[#7f2fff] text-white',
    Borrador: 'bg-[#f22929] text-white',
};

const puedeResponderOferta = computed(() => {
    return props.rolId === 3 && oferta.value.estado === 'Espera';
});

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

const cargarOferta = async () => {
    try {
        cargando.value = true;
        error.value = '';

        const response = await axios.get(`/api/ofertas/${props.ofertaId}`);
        const data = response.data;

        oferta.value = {
            id: data.codi_oferta || data.id,
            estado: estadoTexto[data.estat_oferta_id] || '-',
            validez: formatearFecha(data.data_validessa_fina),
            cliente: data.cliente || '-',
            tipo: tipoFlujoTexto[data.tipus_fluxe_id] || '-',
            incoterm: data.incoterm || '-',
            transporte: tipoTransporteTexto[data.tipus_transport_id] || '-',
            origen: data.origen || '-',
            destino: data.destino || '-',
            shippingLine: data.shipping_line || '-',
            peso: data.pes_brut ?? '-',
            cbm: data.volum ?? '-',
            modalidad: tipoCargaTexto[data.tipus_carrega_id] || '-',
            contenedor: data.tipo_contenedor || '-',
            tamano: data.mida_contenidor ? `${data.mida_contenidor}'` : '-',
            descripcion: data.descripcio_producte || data.comentaris || '-',
        };
    } catch (err) {
        console.error(err);
        error.value = 'No se ha podido cargar la oferta.';
    } finally {
        cargando.value = false;
    }
};

const aceptarOferta = async () => {
    try {
        procesando.value = true;
        error.value = '';

        await axios.patch(`/api/ofertas/${props.ofertaId}/aceptar`);
        await cargarOferta();
    } catch (err) {
        console.error(err);
        error.value = err.response?.data?.message || 'No se ha podido aceptar la oferta.';
    } finally {
        procesando.value = false;
    }
};

const rechazarOferta = async () => {
    try {
        procesando.value = true;
        error.value = '';

        await axios.patch(`/api/ofertas/${props.ofertaId}/rechazar`);
        await cargarOferta();
    } catch (err) {
        console.error(err);
        error.value = err.response?.data?.message || 'No se ha podido rechazar la oferta.';
    } finally {
        procesando.value = false;
    }
};

onMounted(() => {
    cargarOferta();
});
</script>


<template>
    <main class="min-h-screen bg-[#f3f1f3]">
        <div class="fixed inset-x-0 top-0 z-30">
            <HeaderRegistrado title="Detalle de la oferta" subtitle="Consulta la informacion de tu oferta" />
        </div>

        <NavIzquierda :items="menuOperativo" />

        <section class="pl-60 pr-4 pt-32 sm:pl-72 sm:pr-8 lg:pt-36">
            <div class="mx-auto max-w-[1080px]">
                <div class="grid gap-6 xl:grid-cols-[1fr_0.9fr]">
                    <article class="rounded-xl border border-[#ddd6d8] bg-white shadow-[0_2px_10px_rgba(0,0,0,0.08)]">
                        <div class="space-y-6 px-6 py-6 font-montserrat text-[#474344]">
                            <section class="space-y-4">
                                <h2 class="text-[16px] font-semibold text-[#2f2b2c]">Informacion general</h2>

                                <div class="grid gap-4 text-[13px] sm:grid-cols-2">
                                    <div>
                                        <p class="text-[#9f979a]">Cliente:</p>
                                        <p class="font-medium text-[#353233]">{{ oferta.cliente }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[#9f979a]">Tipo:</p>
                                        <p class="font-medium text-[#353233]">{{ oferta.tipo }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[#9f979a]">Incoterms:</p>
                                        <p class="font-medium text-[#353233]">{{ oferta.incoterm }}</p>
                                    </div>
                                </div>
                            </section>

                            <div class="h-px w-full bg-[#e7e1e3]"></div>

                            <section class="space-y-4">
                                <h2 class="text-[16px] font-semibold text-[#2f2b2c]">Transporte</h2>

                                <div class="text-[13px]">
                                    <p class="text-[#9f979a]">Tipo transporte:</p>
                                    <p class="font-medium text-[#353233]">{{ oferta.transporte }}</p>
                                </div>
                            </section>

                            <div class="h-px w-full bg-[#e7e1e3]"></div>

                            <section class="space-y-4">
                                <h2 class="text-[16px] font-semibold text-[#2f2b2c]">Ruta</h2>

                                <div class="flex flex-col gap-3 text-[13px] text-[#353233] sm:flex-row sm:items-center">
                                    <div class="rounded-lg bg-[#f6f3f4] px-4 py-3">
                                        <p class="text-[#9f979a]">Origen</p>
                                        <p class="font-medium">{{ oferta.origen }}</p>
                                    </div>

                                    <div class="flex items-center justify-center text-[#c9c1c3]">
                                        <ChevronRightIcon class="h-5 w-5" />
                                    </div>

                                    <div class="rounded-lg bg-[#f6f3f4] px-4 py-3">
                                        <p class="text-[#9f979a]">Destino</p>
                                        <p class="font-medium">{{ oferta.destino }}</p>
                                    </div>
                                </div>

                                <div class="text-[13px]">
                                    <p class="text-[#9f979a]">Shipping line:</p>
                                    <p class="font-medium text-[#353233]">{{ oferta.shippingLine }}</p>
                                </div>
                            </section>

                            <div v-if="puedeResponderOferta" class="pt-2">
                                <button
                                    type="button"
                                    @click="aceptarOferta"
                                    :disabled="procesando || cargando"
                                    class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-[#cf0b15] to-[#8e0a0f] px-5 py-3 text-[13px] font-semibold text-white shadow-[0_8px_20px_rgba(167,15,22,0.22)] transition hover:scale-[1.01] disabled:cursor-not-allowed disabled:opacity-70"
                                >
                                    Aceptar oferta
                                    <ChevronRightIcon class="h-4 w-4" />
                                </button>
                            </div>
                        </div>
                    </article>

                    <article class="rounded-xl border border-[#ddd6d8] bg-white shadow-[0_2px_10px_rgba(0,0,0,0.08)]">
                        <div class="space-y-5 px-6 py-6 font-montserrat text-[13px] text-[#474344]">
                            <section class="space-y-3">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <div>
                                        <p class="text-[#9f979a]">ID:</p>
                                        <p class="text-[15px] font-semibold text-[#2f2b2c]">{{ oferta.id }}</p>
                                    </div>

                                    <span :class="['inline-flex rounded-full px-3 py-1 text-[11px] font-semibold', estadoClasses[oferta.estado] || 'bg-[#e7e1e3] text-[#514d4e]']">
                                        {{ oferta.estado }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-[#9f979a]">Estado:</p>
                                    <p class="font-medium text-[#353233]">{{ oferta.estado }}</p>
                                </div>

                                <div>
                                    <p class="text-[#9f979a]">Validez:</p>
                                    <p class="font-medium text-[#353233]">{{ oferta.validez }}</p>
                                </div>
                            </section>

                            <div class="h-px w-full bg-[#e7e1e3]"></div>

                            <section class="space-y-4">
                                <h2 class="text-[16px] font-semibold text-[#2f2b2c]">Informacion del contenedor</h2>

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <p class="text-[#9f979a]">Peso:</p>
                                        <p class="font-medium text-[#353233]">{{ oferta.peso }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[#9f979a]">CBM:</p>
                                        <p class="font-medium text-[#353233]">{{ oferta.cbm }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[#9f979a]">Modalidad:</p>
                                        <p class="font-medium text-[#353233]">{{ oferta.modalidad }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[#9f979a]">Tipo:</p>
                                        <p class="font-medium text-[#353233]">{{ oferta.contenedor }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[#9f979a]">Tamano:</p>
                                        <p class="font-medium text-[#353233]">{{ oferta.tamano }}</p>
                                    </div>
                                </div>
                            </section>

                            <div class="h-px w-full bg-[#e7e1e3]"></div>

                            <section class="space-y-3">
                                <h2 class="text-[16px] font-semibold text-[#2f2b2c]">Descripcion</h2>
                                <p class="leading-6 text-[#6d6769]">{{ oferta.descripcion }}</p>
                            </section>

                            <div class="h-px w-full bg-[#e7e1e3]"></div>

                            <section class="space-y-4 text-center">
                                <h2 class="text-[16px] font-semibold text-[#2f2b2c]">Descarga la documentacion</h2>

                                <button
                                    type="button"
                                    class="rounded-md border border-[#d5cfd1] bg-[#f5f2f3] px-5 py-2 text-[12px] font-semibold text-[#4f4a4b] transition hover:bg-[#ece6e8]"
                                >
                                    Descargar
                                </button>
                            </section>

                            <div v-if="puedeResponderOferta" class="pt-2">
                                <button
                                    type="button"
                                    @click="rechazarOferta"
                                    :disabled="procesando || cargando"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-[#cf0b15] to-[#8e0a0f] px-5 py-3 text-[13px] font-semibold text-white shadow-[0_8px_20px_rgba(167,15,22,0.22)] transition hover:scale-[1.01] disabled:cursor-not-allowed disabled:opacity-70"
                                >
                                    Rechazar oferta
                                    <ChevronRightIcon class="h-4 w-4" />
                                </button>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </main>
</template>
