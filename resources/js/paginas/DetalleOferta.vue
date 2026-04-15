<script setup>
import { ChevronRightIcon, ClipboardDocumentListIcon, FolderIcon } from '@heroicons/vue/24/outline';
import { computed } from 'vue';
import HeaderRegistrado from '../components/Header-registrado.vue';
import NavIzquierda from '../components/Navizquierda.vue';

const props = defineProps({
    ofertaId: {
        type: String,
        default: 'OF-2026-001',
    },
});

const menuOperativo = [
    { id: 'dashboard', label: 'Dashboard', icon: '/imagenes/casita.png', path: '/dashboard-operador-cliente', iconType: 'image' },
    { id: 'clientes', label: 'Clientes', icon: '/imagenes/cliente.png', path: '/dashboard-admin', iconType: 'image' },
    { id: 'ofertas', label: 'Ofertas', icon: '', path: '/ofertas', iconType: 'component', iconComponent: ClipboardDocumentListIcon },
    { id: 'operaciones', label: 'Operaciones', icon: '', path: '/operaciones', iconType: 'component', iconComponent: FolderIcon },
];

const ofertas = {
    'OF-2026-001': {
        id: 'OF-2026-001',
        estado: 'Espera',
        validez: '20/05/2026',
        cliente: 'Politecnica',
        tipo: 'Importacion',
        incoterm: 'FOB',
        transporte: 'Maritimo',
        origen: 'Puerto Llano',
        destino: 'Puerto Rico',
        shippingLine: 'MSC',
        peso: '2.200 Kg',
        cbm: '28 CBM',
        modalidad: 'FCL',
        contenedor: 'Refrigerado',
        tamano: "20'",
        descripcion: 'Carga general correctamente embalada y apta para transporte maritimo. Distribuida en volumen y peso especificados.',
    },
    'OF-2026-002': {
        id: 'OF-2026-002',
        estado: 'Aceptada',
        validez: '22/05/2026',
        cliente: 'Norte Export',
        tipo: 'Exportacion',
        incoterm: 'FOB',
        transporte: 'Terrestre',
        origen: 'Madrid',
        destino: 'Barcelona',
        shippingLine: 'Dachser',
        peso: '1.450 Kg',
        cbm: '14 CBM',
        modalidad: 'LTL',
        contenedor: 'Seco',
        tamano: "40'",
        descripcion: 'Expedicion con recogida programada y entrega prioritaria para distribucion nacional.',
    },
    'OF-2026-003': {
        id: 'OF-2026-003',
        estado: 'Rechazada',
        validez: '25/05/2026',
        cliente: 'Pacific Trade',
        tipo: 'Exportacion',
        incoterm: 'FOB',
        transporte: 'Aereo',
        origen: 'Melbourne',
        destino: 'Algeciras',
        shippingLine: 'Qatar Cargo',
        peso: '860 Kg',
        cbm: '9 CBM',
        modalidad: 'ULD',
        contenedor: 'Temperatura controlada',
        tamano: 'Aereo',
        descripcion: 'Mercancia sensible con ventana corta de entrega y requisitos reforzados de trazabilidad.',
    },
    'OF-2026-004': {
        id: 'OF-2026-004',
        estado: 'Borrador',
        validez: '30/05/2026',
        cliente: 'Euro Container',
        tipo: 'Importacion',
        incoterm: 'FOB',
        transporte: 'Maritimo',
        origen: 'Rotterdam',
        destino: 'Bilbao',
        shippingLine: 'Maersk',
        peso: '3.100 Kg',
        cbm: '33 CBM',
        modalidad: 'FCL',
        contenedor: 'Refrigerado',
        tamano: "20'",
        descripcion: 'Oferta en revision interna pendiente de validacion comercial y cierre de costes asociados.',
    },
    'OF-2026-005': {
        id: 'OF-2026-005',
        estado: 'Rechazada',
        validez: '28/05/2026',
        cliente: 'Bangkok Foods',
        tipo: 'Importacion',
        incoterm: 'FOB',
        transporte: 'Maritimo',
        origen: 'Valencia',
        destino: 'Bangkok',
        shippingLine: 'ONE',
        peso: '2.980 Kg',
        cbm: '30 CBM',
        modalidad: 'FCL',
        contenedor: 'Refrigerado',
        tamano: "40'",
        descripcion: 'Operacion internacional con cadena de frio y programacion flexible segun salida de buque.',
    },
};

const estadoClasses = {
    Espera: 'bg-[#f0bf62] text-white',
    Aceptada: 'bg-[#5f8d67] text-white',
    Rechazada: 'bg-[#7f2fff] text-white',
    Borrador: 'bg-[#f22929] text-white',
};

const oferta = computed(() => {
    return ofertas[props.ofertaId] || {
        id: props.ofertaId,
        estado: 'Espera',
        validez: 'Pendiente',
        cliente: 'Cliente no disponible',
        tipo: 'Sin definir',
        incoterm: 'Sin definir',
        transporte: 'Sin definir',
        origen: 'Pendiente',
        destino: 'Pendiente',
        shippingLine: 'Pendiente',
        peso: 'Pendiente',
        cbm: 'Pendiente',
        modalidad: 'Pendiente',
        contenedor: 'Pendiente',
        tamano: 'Pendiente',
        descripcion: 'No se han encontrado mas datos para esta oferta todavia.',
    };
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

                            <div class="pt-2">
                                <button
                                    type="button"
                                    class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-[#cf0b15] to-[#8e0a0f] px-5 py-3 text-[13px] font-semibold text-white shadow-[0_8px_20px_rgba(167,15,22,0.22)] transition hover:scale-[1.01]"
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

                            <div class="pt-2">
                                <button
                                    type="button"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-[#cf0b15] to-[#8e0a0f] px-5 py-3 text-[13px] font-semibold text-white shadow-[0_8px_20px_rgba(167,15,22,0.22)] transition hover:scale-[1.01]"
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
