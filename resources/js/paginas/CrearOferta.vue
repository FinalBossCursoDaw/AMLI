<script setup>
import { ArrowLeftIcon, ChevronRightIcon, ClipboardDocumentListIcon, FolderIcon } from '@heroicons/vue/24/outline';
import { computed, onMounted, reactive, ref } from 'vue';
import axios from 'axios';

import HeaderRegistrado from '../components/Header-registrado.vue';
import NavIzquierda from '../components/Navizquierda.vue';

const menuOperativo = [
    { id: 'dashboard', label: 'Dashboard', icon: '/imagenes/casita.png', path: '/dashboard-operador-cliente', iconType: 'image' },
    { id: 'clientes', label: 'Clientes', icon: '/imagenes/cliente.png', path: '/dashboard-admin', iconType: 'image' },
    { id: 'ofertas', label: 'Ofertas', icon: '', path: '/ofertas', iconType: 'component', iconComponent: ClipboardDocumentListIcon },
    { id: 'operaciones', label: 'Operaciones', icon: '', path: '/operaciones', iconType: 'component', iconComponent: FolderIcon },
];

const pasoActual = ref(1);
const enviada = ref(false);
const guardando = ref(false);
const cargandoOpciones = ref(true);
const errorGuardado = ref('');
const errorOpciones = ref('');

const clientes = ref([]);
const incoterms = ref([]);
const puertos = ref([]);
const aeropuertos = ref([]);
const carriers = ref([]);
const contenedores = ref([]);
const agentesComerciales = ref([]);

const pesos = ['500 Kg', '1.250 Kg', '2.200 Kg', '3.000 Kg'];
const cbmOptions = ['8 CBM', '14 CBM', '20 CBM', '28 CBM'];

const formulario = reactive({
    cliente: '',
    agenteComercial: '',
    tipo: 'Export',
    incoterm: '',
    transporte: 'Maritimo',
    validez: '',
    origen: '',
    destino: '',
    origenAereo: '',
    destinoAereo: '',
    carrier: '',
    contenedor: '',
    tamano: "40'",
    modalidad: 'FCL',
    peso: '',
    cbm: '',
    descripcion: '',
});

const esMaritimo = computed(() => formulario.transporte === 'Maritimo');
const esAereo = computed(() => formulario.transporte === 'Aereo');

const obtenerNombrePorId = (lista, id, campoNombre) => {
    if (!id) {
        return '---';
    }

    const opcion = lista.find((item) => {
        return String(item.id) === String(id);
    });

    return opcion ? opcion[campoNombre] : '---';
};

const convertirTextoANumero = (texto, sufijo) => {
    if (!texto) {
        return null;
    }

    const numeroLimpio = texto
        .replace(` ${sufijo}`, '')
        .replace(/\./g, '')
        .replace(',', '.');

    const numero = Number(numeroLimpio);

    return Number.isNaN(numero) ? null : numero;
};

const obtenerTipoTransporteId = () => {
    const mapa = {
        Maritimo: 1,
        Aereo: 2,
        Terrestre: 3,
    };

    return mapa[formulario.transporte] || null;
};

const obtenerTipoFluxeId = () => {
    const mapa = {
        Import: 1,
        Export: 2,
    };

    return mapa[formulario.tipo] || null;
};

const obtenerTipoCarregaId = () => {
    if (formulario.modalidad === 'FCL') {
        return 1;
    }

    return 2;
};

const obtenerMensajeError = (error) => {
    const errores = error.response?.data?.errors;

    if (!errores) {
        return 'No se ha podido guardar la oferta.';
    }

    return Object.values(errores).flat().join(' ');
};



const irSiguiente = () => {
    pasoActual.value = 2;
};

const irAnterior = () => {
    pasoActual.value = 1;
    enviada.value = false;
};

const cargarOpcionesFormulario = async () => {
    try {
        cargandoOpciones.value = true;
        errorOpciones.value = '';

        const response = await axios.get('/api/ofertas/formulario');

        clientes.value = response.data.clientes;
        incoterms.value = response.data.incoterms;
        puertos.value = response.data.ports;
        aeropuertos.value = response.data.aeroports;
        carriers.value = response.data.linies_transport_maritim;
        contenedores.value = response.data.tipus_contenidors;
        agentesComerciales.value = response.data.agents_comercials;

        if (!formulario.origen && puertos.value.length > 0) {
            formulario.origen = puertos.value[0].id;
        }

        if (!formulario.destino && puertos.value.length > 1) {
            formulario.destino = puertos.value[1].id;
        } else if (!formulario.destino && puertos.value.length > 0) {
            formulario.destino = puertos.value[0].id;
        }

        if (!formulario.origenAereo && aeropuertos.value.length > 0) {
            formulario.origenAereo = aeropuertos.value[0].id;
        }

        if (!formulario.destinoAereo && aeropuertos.value.length > 1) {
            formulario.destinoAereo = aeropuertos.value[1].id;
        } else if (!formulario.destinoAereo && aeropuertos.value.length > 0) {
            formulario.destinoAereo = aeropuertos.value[0].id;
        }
    } catch (error) {
        console.error(error);
        errorOpciones.value = 'No se han podido cargar los datos del formulario.';
    } finally {
        cargandoOpciones.value = false;
    }
};

const guardarEnviar = async () => {
    guardando.value = true;
    errorGuardado.value = '';
    enviada.value = false;

    try {
        const datosOferta = {
            client_id: formulario.cliente || null,
            agent_comercial_id: formulario.agenteComercial || null,
            tipus_transport_id: obtenerTipoTransporteId(),
            tipus_fluxe_id: obtenerTipoFluxeId(),
            tipus_carrega_id: obtenerTipoCarregaId(),
            incoterm_id: formulario.incoterm || null,
            comentaris: formulario.descripcion || null,
            pes_brut: convertirTextoANumero(formulario.peso, 'Kg'),
            volum: convertirTextoANumero(formulario.cbm, 'CBM'),
            port_origen_id: esMaritimo.value ? (formulario.origen || null) : null,
            port_desti_id: esMaritimo.value ? (formulario.destino || null) : null,
            aeroport_origen_id: esAereo.value ? (formulario.origenAereo || null) : null,
            aeroport_desti_id: esAereo.value ? (formulario.destinoAereo || null) : null,
            linia_transport_maritim_id: esMaritimo.value ? (formulario.carrier || null) : null,
            tipus_contenidor_id: formulario.contenedor || null,
            mida_contenidor: formulario.tamano.replace("'", ''),
            descripcio_producte: formulario.descripcion || null,
            data_validessa_fina: formulario.validez || null,
        };

        const response = await axios.post('/api/ofertas', datosOferta);

        console.log(response.data);
        enviada.value = true;
    } catch (error) {
        console.error(error);
        errorGuardado.value = obtenerMensajeError(error);
    } finally {
        guardando.value = false;
    }
};

onMounted(() => {
    cargarOpcionesFormulario();
});
</script>

<template>
    <main class="min-h-screen bg-[#f3f1f3]">
        <div class="fixed inset-x-0 top-0 z-30">
            <HeaderRegistrado title="Crear Oferta" subtitle="Completa los datos para generar una oferta comercial" />
        </div>

        <NavIzquierda :items="menuOperativo" />

        <section class="pl-60 pr-4 pt-32 sm:pl-72 sm:pr-8 lg:pt-36">
            <div class="mx-auto max-w-[1120px]">
                <div class="grid gap-6">
                    <article class="rounded-xl border border-[#ddd6d8] bg-white shadow-[0_2px_10px_rgba(0,0,0,0.08)]">
                        <div class="border-b border-[#ece6e8] px-6 py-5">
                            <div class="flex min-w-0 flex-1 items-center">
                                <div class="flex items-center gap-3 text-[13px] font-medium">
                                    <div
                                        :class="[
                                            'flex h-6 w-6 items-center justify-center rounded-full text-[11px] font-semibold',
                                            pasoActual === 1 ? 'bg-[#7f9b81] text-white' : 'bg-[#efebec] text-[#a59ea0]'
                                        ]"
                                    >
                                        1
                                    </div>
                                    <span :class="pasoActual === 1 ? 'text-[#2f2b2c]' : 'text-[#b5adaf]'">Informacion general</span>
                                </div>

                                <div :class="['mx-4 h-px flex-1', pasoActual === 2 ? 'bg-[#8aa08c]' : 'bg-[#e5dfe1]']"></div>

                                <div class="flex items-center gap-3 text-[13px] font-medium">
                                    <div
                                        :class="[
                                            'flex h-6 w-6 items-center justify-center rounded-full text-[11px] font-semibold',
                                            pasoActual === 2 ? 'bg-[#7f9b81] text-white' : 'bg-[#efebec] text-[#a59ea0]'
                                        ]"
                                    >
                                        2
                                    </div>
                                    <span :class="pasoActual === 2 ? 'text-[#2f2b2c]' : 'text-[#b5adaf]'">Descripcion</span>
                                </div>
                            </div>
                        </div>

                        <div v-if="pasoActual === 1" class="space-y-7 px-6 py-6 font-montserrat text-[13px] text-[#474344]">
                            <p v-if="cargandoOpciones" class="text-[12px] text-[#6f686a]">
                                Cargando opciones del formulario...
                            </p>

                            <p v-if="errorOpciones" class="rounded-lg border border-[#f1d4d4] bg-[#fff5f5] px-4 py-3 text-[12px] text-[#b42318]">
                                {{ errorOpciones }}
                            </p>

                            <section class="space-y-4">
                                <h2 class="text-[16px] font-semibold text-[#2f2b2c]">Informacion general</h2>

                                <div class="grid gap-4">
                                    <label class="grid gap-2 md:grid-cols-[90px_1fr] md:items-center">
                                        <span class="text-[#6f686a]">Cliente</span>
                                        <select v-model="formulario.cliente" class="h-10 rounded-md border border-[#ebe6e8] bg-white px-3 text-[12px] text-[#4e4a4b] outline-none transition focus:border-[#cfb8bb]">
                                            <option value="">Selecciona el cliente</option>
                                            <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">{{ cliente.nom_empresa }}</option>
                                        </select>
                                    </label>

                                    <label class="grid gap-2 md:grid-cols-[90px_1fr] md:items-center">
                                        <span class="text-[#6f686a]">Comercial</span>
                                        <select
                                            v-model="formulario.agenteComercial"
                                            class="h-10 rounded-md border border-[#ebe6e8] bg-white px-3 text-[12px] text-[#4e4a4b] outline-none transition focus:border-[#cfb8bb]"
                                        >
                                            <option value="">Selecciona el comercial</option>
                                            <option v-for="agente in agentesComerciales" :key="agente.id" :value="agente.id">
                                                {{ agente.nom }} {{ agente.cognoms }}
                                            </option>
                                        </select>
                                    </label>

                                    <div class="grid gap-2 md:grid-cols-[90px_1fr] md:items-center">
                                        <span class="text-[#6f686a]">Tipo</span>
                                        <div class="flex flex-wrap gap-6">
                                            <label class="flex items-center gap-2">
                                                <input v-model="formulario.tipo" type="radio" value="Import" class="h-3.5 w-3.5 accent-[#5c7cff]" />
                                                <span>Import</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input v-model="formulario.tipo" type="radio" value="Export" class="h-3.5 w-3.5 accent-[#5c7cff]" />
                                                <span>Export</span>
                                            </label>
                                        </div>
                                    </div>

                                    <label class="grid gap-2 md:grid-cols-[90px_1fr] md:items-center">
                                        <span class="text-[#6f686a]">Incoterm</span>
                                        <select v-model="formulario.incoterm" class="h-10 rounded-md border border-[#ebe6e8] bg-white px-3 text-[12px] text-[#4e4a4b] outline-none transition focus:border-[#cfb8bb]">
                                            <option value="">Seleccionar incoterm</option>
                                            <option v-for="incoterm in incoterms" :key="incoterm.id" :value="incoterm.id">{{ incoterm.codi }}</option>
                                        </select>
                                    </label>
                                </div>
                            </section>

                            <div class="h-px w-full bg-[#ece6e8]"></div>

                            <section class="space-y-4">
                                <h2 class="text-[16px] font-semibold text-[#2f2b2c]">Transporte</h2>

                                <div class="grid gap-4">
                                    <div class="grid gap-2 md:grid-cols-[90px_1fr] md:items-center">
                                        <span class="text-[#6f686a]">Tipo</span>
                                        <div class="flex flex-wrap gap-2">
                                            <button
                                                type="button"
                                                @click="formulario.transporte = 'Maritimo'"
                                                :class="[
                                                    'rounded-md border px-3 py-1.5 text-[12px] transition',
                                                    formulario.transporte === 'Maritimo' ? 'border-[#7f9b81] bg-[#7f9b81] text-white' : 'border-[#ebe6e8] bg-white text-[#6d6769]'
                                                ]"
                                            >
                                                Maritimo
                                            </button>
                                            <button
                                                type="button"
                                                @click="formulario.transporte = 'Aereo'"
                                                :class="[
                                                    'rounded-md border px-3 py-1.5 text-[12px] transition',
                                                    formulario.transporte === 'Aereo' ? 'border-[#7f9b81] bg-[#7f9b81] text-white' : 'border-[#ebe6e8] bg-white text-[#6d6769]'
                                                ]"
                                            >
                                                Aereo
                                            </button>
                                            <button
                                                type="button"
                                                @click="formulario.transporte = 'Terrestre'"
                                                :class="[
                                                    'rounded-md border px-3 py-1.5 text-[12px] transition',
                                                    formulario.transporte === 'Terrestre' ? 'border-[#7f9b81] bg-[#7f9b81] text-white' : 'border-[#ebe6e8] bg-white text-[#6d6769]'
                                                ]"
                                            >
                                                Terrestre
                                            </button>
                                        </div>
                                    </div>

                                    <label class="grid gap-2 md:grid-cols-[90px_1fr] md:items-center">
                                        <span class="text-[#6f686a]">Validez</span>
                                        <input v-model="formulario.validez" type="date" class="h-10 rounded-md border border-[#ebe6e8] bg-white px-3 text-[12px] text-[#4e4a4b] outline-none transition focus:border-[#cfb8bb]" />
                                    </label>
                                </div>
                            </section>

                            <div class="h-px w-full bg-[#ece6e8]"></div>

                            <section class="space-y-4">
                                <h2 class="text-[16px] font-semibold text-[#2f2b2c]">Ruta y partners</h2>

                                <div class="grid gap-4">
                                    <div v-if="esMaritimo" class="grid gap-3 lg:grid-cols-[90px_1fr_24px_1fr] lg:items-center">
                                        <span class="text-[#6f686a]">Puertos</span>

                                        <select v-model="formulario.origen" class="h-10 rounded-md border border-[#ebe6e8] bg-white px-3 text-[12px] text-[#4e4a4b] outline-none transition focus:border-[#cfb8bb]">
                                            <option value="">Selecciona origen</option>
                                            <option v-for="puerto in puertos" :key="`origen-${puerto.id}`" :value="puerto.id">{{ puerto.nom }}</option>
                                        </select>

                                        <div class="flex items-center justify-center text-[#b5adaf]">
                                            <ChevronRightIcon class="h-4 w-4" />
                                        </div>

                                        <select v-model="formulario.destino" class="h-10 rounded-md border border-[#ebe6e8] bg-white px-3 text-[12px] text-[#4e4a4b] outline-none transition focus:border-[#cfb8bb]">
                                            <option value="">Selecciona destino</option>
                                            <option v-for="puerto in puertos" :key="`destino-${puerto.id}`" :value="puerto.id">{{ puerto.nom }}</option>
                                        </select>
                                    </div>

                                    <div v-else-if="esAereo" class="grid gap-3 lg:grid-cols-[90px_1fr_24px_1fr] lg:items-center">
                                        <span class="text-[#6f686a]">Aeropuertos</span>

                                        <select v-model="formulario.origenAereo" class="h-10 rounded-md border border-[#ebe6e8] bg-white px-3 text-[12px] text-[#4e4a4b] outline-none transition focus:border-[#cfb8bb]">
                                            <option value="">Selecciona origen</option>
                                            <option v-for="aeropuerto in aeropuertos" :key="`aeropuerto-origen-${aeropuerto.id}`" :value="aeropuerto.id">{{ aeropuerto.nom }}</option>
                                        </select>

                                        <div class="flex items-center justify-center text-[#b5adaf]">
                                            <ChevronRightIcon class="h-4 w-4" />
                                        </div>

                                        <select v-model="formulario.destinoAereo" class="h-10 rounded-md border border-[#ebe6e8] bg-white px-3 text-[12px] text-[#4e4a4b] outline-none transition focus:border-[#cfb8bb]">
                                            <option value="">Selecciona destino</option>
                                            <option v-for="aeropuerto in aeropuertos" :key="`aeropuerto-destino-${aeropuerto.id}`" :value="aeropuerto.id">{{ aeropuerto.nom }}</option>
                                        </select>
                                    </div>

                                    <div v-else class="rounded-lg border border-[#ebe6e8] bg-[#f8f6f7] px-4 py-3 text-[12px] text-[#6d6769]">
                                        El transporte terrestre no necesita puertos ni aeropuertos en este formulario.
                                    </div>

                                    <label v-if="esMaritimo" class="grid gap-2 md:grid-cols-[90px_1fr] md:items-center">
                                        <span class="text-[#6f686a]">Shipping line</span>
                                        <select v-model="formulario.carrier" class="h-10 rounded-md border border-[#ebe6e8] bg-white px-3 text-[12px] text-[#4e4a4b] outline-none transition focus:border-[#cfb8bb]">
                                            <option value="">Seleccionar naviera / Carrier</option>
                                            <option v-for="carrier in carriers" :key="carrier.id" :value="carrier.id">{{ carrier.nom }}</option>
                                        </select>
                                    </label>
                                </div>
                            </section>

                            <div class="flex justify-end border-t border-[#ece6e8] pt-5">
                                <button
                                    type="button"
                                    @click="irSiguiente"
                                    class="inline-flex items-center gap-2 rounded-lg border border-[#ddd6d8] bg-white px-5 py-2 text-[12px] font-semibold text-[#4f4a4b] transition hover:bg-[#f7f3f4]"
                                >
                                    Siguiente
                                    <ChevronRightIcon class="h-4 w-4 text-[#d31318]" />
                                </button>
                            </div>
                        </div>

                        <div v-else class="space-y-7 px-6 py-6 font-montserrat text-[13px] text-[#474344]">
                            <section class="space-y-4">
                                <h2 class="text-[16px] font-semibold text-[#2f2b2c]">Informacion del contenedor</h2>

                                <div class="grid gap-4">
                                    <label class="grid gap-2 md:grid-cols-[130px_1fr] md:items-center">
                                        <span class="text-[#6f686a]">Tipo contenedor</span>
                                        <select v-model="formulario.contenedor" class="h-10 rounded-md border border-[#ebe6e8] bg-white px-3 text-[12px] text-[#4e4a4b] outline-none transition focus:border-[#cfb8bb]">
                                            <option value="">Selecciona el tipo</option>
                                            <option v-for="contenedor in contenedores" :key="contenedor.id" :value="contenedor.id">{{ contenedor.tipus }}</option>
                                        </select>
                                    </label>

                                    <div class="grid gap-2 md:grid-cols-[130px_1fr] md:items-center">
                                        <span class="text-[#6f686a]">Tamano</span>
                                        <div class="flex flex-wrap gap-6">
                                            <label class="flex items-center gap-2">
                                                <input v-model="formulario.tamano" type="radio" value="20'" class="h-3.5 w-3.5 accent-[#5c7cff]" />
                                                <span>20'</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <input v-model="formulario.tamano" type="radio" value="40'" class="h-3.5 w-3.5 accent-[#5c7cff]" />
                                                <span>40'</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <div class="h-px w-full bg-[#ece6e8]"></div>

                            <section class="space-y-4">
                                <h2 class="text-[16px] font-semibold text-[#2f2b2c]">Informacion del producto</h2>

                                <div class="grid gap-4">
                                    <div class="grid gap-4 md:grid-cols-2">
                                        <label class="grid gap-2">
                                            <span class="text-[#6f686a]">Peso</span>
                                            <select v-model="formulario.peso" class="h-10 rounded-md border border-[#ebe6e8] bg-white px-3 text-[12px] text-[#4e4a4b] outline-none transition focus:border-[#cfb8bb]">
                                                <option value="">Selecciona el peso</option>
                                                <option v-for="peso in pesos" :key="peso" :value="peso">{{ peso }}</option>
                                            </select>
                                        </label>

                                        <label class="grid gap-2">
                                            <span class="text-[#6f686a]">Cbm(Volumen)</span>
                                            <select v-model="formulario.cbm" class="h-10 rounded-md border border-[#ebe6e8] bg-white px-3 text-[12px] text-[#4e4a4b] outline-none transition focus:border-[#cfb8bb]">
                                                <option value="">Selecciona el cbm</option>
                                                <option v-for="cbm in cbmOptions" :key="cbm" :value="cbm">{{ cbm }}</option>
                                            </select>
                                        </label>
                                    </div>

                                    <div class="flex flex-wrap gap-6">
                                        <label class="flex items-center gap-2">
                                            <input v-model="formulario.modalidad" type="radio" value="FCL" class="h-3.5 w-3.5 accent-[#5c7cff]" />
                                            <span>FCL</span>
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input v-model="formulario.modalidad" type="radio" value="LCL" class="h-3.5 w-3.5 accent-[#5c7cff]" />
                                            <span>LCL</span>
                                        </label>
                                    </div>

                                    <label class="grid gap-2">
                                        <span class="text-[#6f686a]">Descripcion del producto</span>
                                        <textarea
                                            v-model="formulario.descripcion"
                                            rows="4"
                                            placeholder="Descripcion"
                                            class="rounded-md border border-[#ebe6e8] bg-white px-3 py-3 text-[12px] text-[#4e4a4b] outline-none transition focus:border-[#cfb8bb] placeholder:text-[#b5adaf]"
                                        ></textarea>
                                    </label>
                                </div>
                            </section>

                            <div class="flex flex-col gap-3 border-t border-[#ece6e8] pt-5 sm:flex-row sm:items-center sm:justify-between">
                                <button
                                    type="button"
                                    @click="irAnterior"
                                    class="inline-flex items-center gap-2 rounded-lg border border-[#ddd6d8] bg-white px-5 py-2 text-[12px] font-semibold text-[#4f4a4b] transition hover:bg-[#f7f3f4]"
                                >
                                    <ArrowLeftIcon class="h-4 w-4 text-[#d31318]" />
                                    Anterior
                                </button>

                                <button
                                    type="button"
                                    @click="guardarEnviar"
                                    :disabled="guardando || cargandoOpciones"
                                    class="inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-[#ff2d22] to-[#cf0b15] px-5 py-2 text-[12px] font-semibold text-white shadow-[0_8px_20px_rgba(207,11,21,0.22)] transition hover:scale-[1.01] disabled:cursor-not-allowed disabled:opacity-70"
                                >
                                    {{ guardando ? 'Guardando...' : 'Guardar y enviar' }}
                                </button>
                            </div>

                            <p v-if="enviada" class="rounded-lg border border-[#dfe8e0] bg-[#f3f8f4] px-4 py-3 text-[12px] text-[#4c6d52]">
                                Oferta guardada y enviada correctamente.
                            </p>

                            <p v-if="errorGuardado" class="rounded-lg border border-[#f1d4d4] bg-[#fff5f5] px-4 py-3 text-[12px] text-[#b42318]">
                                {{ errorGuardado }}
                            </p>
                        </div>
                    </article>

                </div>
            </div>
        </section>
    </main>
</template>
 
