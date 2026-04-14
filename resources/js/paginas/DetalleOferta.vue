<script setup>
import { ChevronRightIcon, ClipboardDocumentListIcon, FolderIcon } from '@heroicons/vue/24/outline';
import { computed } from 'vue';
import HeaderRegistrado from '../components/Header-registrado.vue';
import NavIzquierda from '../components/Navizquierda.vue';

const menuOperativo = [
    { id: 'dashboard', label: 'Dashboard', icon: '/imagenes/casita.png', path: '/dashboard-operador-cliente', iconType: 'image' },
    { id: 'clientes', label: 'Clientes', icon: '/imagenes/cliente.png', path: '/dashboard-admin', iconType: 'image' },
    { id: 'ofertas', label: 'Ofertas', icon: '', path: '/ofertas', iconType: 'component', iconComponent: ClipboardDocumentListIcon },
    { id: 'operaciones', label: 'Operaciones', icon: '', path: '/operaciones', iconType: 'component', iconComponent: FolderIcon },
];

const ofertas = [
    {
        id: 'OF-2026-001',
        cliente: 'Politecnics',
        tipo: 'Importacion',
        incoterm: 'FBO',
        estado: 'Espera',
        validez: '20/05/2026',
        transporte: 'Maritimo',
        origen: 'Puertollano',
        destino: 'Puerto Rico',
        shippingLine: 'MSC',
        peso: '2.200 Kg',
        cbm: '28 CBM',
        modalidad: 'FCL',
        contenedor: 'Refrigerado',
        tamano: "20'",
        descripcion: 'Carga general correctamente embalada y apta para transporte maritimo. Distribuida en contenedor segun volumen y peso especificados.',
    },
    {
        id: 'OF-2026-002',
        cliente: 'Global Retail',
        tipo: 'Exportacion',
        incoterm: 'FOB',
        estado: 'Aceptada',
        validez: '11/06/2026',
        transporte: 'Terrestre',
        origen: 'Madrid',
        destino: 'Barcelona',
        shippingLine: 'DB Schenker',
        peso: '1.100 Kg',
        cbm: '12 CBM',
        modalidad: 'LTL',
        contenedor: 'Seco',
        tamano: "40'",
        descripcion: 'Mercancia paletizada para salida nacional, con entrega en plataforma logistica y control documental completo.',
    },
    {
        id: 'OF-2026-003',
        cliente: 'Navas Exports',
        tipo: 'Exportacion',
        incoterm: 'FOB',
        estado: 'Rechazada',
        validez: '04/07/2026',
        transporte: 'Aereo',
        origen: 'Melbourne',
        destino: 'Algeciras',
        shippingLine: 'Qatar Cargo',
        peso: '680 Kg',
        cbm: '5 CBM',
        modalidad: 'Air Freight',
        contenedor: 'Especial',
        tamano: "10'",
        descripcion: 'Envio urgente con restricciones de manipulacion y seguimiento prioritario desde origen hasta destino.',
    },
    {
        id: 'OF-2026-004',
        cliente: 'Industries Garza',
        tipo: 'Importacion',
        incoterm: 'FOB',
        estado: 'Borrador',
        validez: '18/08/2026',
        transporte: 'Maritimo',
        origen: 'Rotterdam',
        destino: 'Bilbao',
        shippingLine: 'Maersk',
        peso: '3.400 Kg',
        cbm: '31 CBM',
        modalidad: 'FCL',
        contenedor: 'Refrigerado',
        tamano: "40'",
        descripcion: 'Operacion pendiente de validacion interna antes de enviar propuesta definitiva al cliente.',
    },
    {
        id: 'OF-2026-005',
        cliente: 'Saturn Freight',
        tipo: 'Importacion',
        incoterm: 'FOB',
        estado: 'Rechazada',
        validez: '02/09/2026',
        transporte: 'Maritimo',
        origen: 'Valencia',
        destino: 'Bangkok',
        shippingLine: 'Evergreen',
        peso: '4.100 Kg',
        cbm: '36 CBM',
        modalidad: 'FCL',
        contenedor: 'Refrigerado',
        tamano: "40'",
        descripcion: 'Operacion de largo recorrido con escala internacional y requisitos de temperatura controlada.',
    },
];

const parametros = new URLSearchParams(window.location.search);
const ofertaId = parametros.get('id') || 'OF-2026-001';

const oferta = computed(() => {
    return ofertas.find((item) => item.id === ofertaId) || ofertas[0];
});
</script>

<template>
    <main class="min-h-screen bg-[#f3f1f3]">
        <div class="fixed inset-x-0 top-0 z-30">
            <HeaderRegistrado title="Detalle de la oferta" subtitle="Consulta la informacion de tu oferta" />
        </div>

        <NavIzquierda :items="menuOperativo" />

        <section class="pl-72 pr-8 pt-40 sm:pr-10 lg:pt-44">
            <div class="mx-auto grid max-w-[980px] gap-8 lg:grid-cols-2">
                <article class="rounded-xl border border-[#ddd6d8] bg-white px-6 py-5 shadow-[0_2px_10px_rgba(0,0,0,0.08)]">
                    <section>
                        <h2 class="font-montserrat text-[15px] font-semibold text-[#353233]">Informacion general</h2>

                        <dl class="mt-5 space-y-5 font-montserrat text-[13px] text-[#454041]">
                            <div class="grid grid-cols-[80px_1fr] gap-3">
                                <dt class="text-[#9a9396]">Cliente:</dt>
                                <dd>{{ oferta.cliente }}</dd>
                            </div>

                            <div class="grid grid-cols-[80px_1fr] gap-3">
                                <dt class="text-[#9a9396]">Tipo:</dt>
                                <dd>{{ oferta.tipo }}</dd>
                            </div>

                            <div class="grid grid-cols-[80px_1fr] gap-3">
                                <dt class="text-[#9a9396]">Incoterms:</dt>
                                <dd>{{ oferta.incoterm }}</dd>
                            </div>
                        </dl>
                    </section>

                    <section class="mt-6 border-t border-[#ece6e8] pt-4">
                        <h3 class="font-montserrat text-[15px] font-semibold text-[#353233]">Transporte</h3>

                        <div class="mt-4 grid grid-cols-[120px_1fr] gap-3 font-montserrat text-[13px] text-[#454041]">
                            <p class="text-[#9a9396]">Tipo transporte:</p>
                            <p>{{ oferta.transporte }}</p>
                        </div>
                    </section>

                    <section class="mt-6 border-t border-[#ece6e8] pt-4">
                        <h3 class="font-montserrat text-[15px] font-semibold text-[#353233]">Ruta</h3>

                        <div class="mt-4 flex items-center gap-3 font-montserrat text-[13px] text-[#454041]">
                            <span><span class="text-[#9a9396]">Origen:</span> {{ oferta.origen }}</span>
                            <ChevronRightIcon class="h-4 w-4 text-[#d1c9cc]" />
                            <span><span class="text-[#9a9396]">Destino:</span> {{ oferta.destino }}</span>
                        </div>

                        <div class="mt-6 grid grid-cols-[95px_1fr] gap-3 font-montserrat text-[13px] text-[#454041]">
                            <p class="text-[#9a9396]">Shipping line:</p>
                            <p>{{ oferta.shippingLine }}</p>
                        </div>
                    </section>

                    <div class="mt-10 rounded-lg border border-[#eee8ea] bg-[#faf8f9] px-5 py-4 text-center font-montserrat text-[12px] text-[#6b6568]">
                        Vista de consulta para operador. Desde aqui puedes revisar la informacion de la oferta, pero no cambiar su estado.
                    </div>
                </article>

                <article class="rounded-xl border border-[#ddd6d8] bg-white px-6 py-5 shadow-[0_2px_10px_rgba(0,0,0,0.08)]">
                    <section class="font-montserrat text-[13px] text-[#454041]">
                        <h2 class="text-[15px] font-semibold text-[#353233]">ID: {{ oferta.id }}</h2>
                        <p class="mt-2"><span class="text-[#9a9396]">Estado:</span> {{ oferta.estado }}</p>
                        <p class="mt-1"><span class="text-[#9a9396]">Validez:</span> {{ oferta.validez }}</p>
                    </section>

                    <section class="mt-6 border-t border-[#ece6e8] pt-4">
                        <h3 class="font-montserrat text-[15px] font-semibold text-[#353233]">Informacion del contenedor</h3>

                        <div class="mt-4 grid grid-cols-2 gap-x-6 gap-y-4 font-montserrat text-[13px] text-[#454041]">
                            <p><span class="text-[#9a9396]">Peso:</span> {{ oferta.peso }}</p>
                            <p><span class="text-[#9a9396]">CBM:</span> {{ oferta.cbm }}</p>
                            <p><span class="text-[#9a9396]">Modalidad:</span> {{ oferta.modalidad }}</p>
                            <p><span class="text-[#9a9396]">Tipo:</span> {{ oferta.contenedor }}</p>
                            <p><span class="text-[#9a9396]">Tamano:</span> {{ oferta.tamano }}</p>
                        </div>
                    </section>

                    <section class="mt-6 border-t border-[#ece6e8] pt-4">
                        <h3 class="font-montserrat text-[15px] font-semibold text-[#353233]">Descripcion</h3>
                        <p class="mt-3 max-w-[360px] font-montserrat text-[12px] leading-5 text-[#6b6568]">
                            {{ oferta.descripcion }}
                        </p>
                    </section>

                    <section class="mt-6 border-t border-[#ece6e8] pt-4 text-center">
                        <h3 class="font-montserrat text-[15px] font-semibold text-[#353233]">Descarga la documentacion</h3>
                        <button
                            type="button"
                            class="mt-4 rounded-md border border-[#d9d2d5] bg-[#f7f4f5] px-6 py-1.5 font-montserrat text-[12px] text-[#4f4a4b] shadow-sm transition hover:bg-[#ebe6e8]"
                        >
                            Descargar
                        </button>
                    </section>

                    <div class="mt-8 flex justify-center">
                        <a
                            href="/ofertas"
                            class="inline-flex items-center gap-3 rounded-lg bg-[#f3eff0] px-7 py-3 font-montserrat text-[13px] font-semibold text-[#4f4a4b] shadow-sm transition hover:bg-[#e8e1e3]"
                        >
                            Volver a ofertas
                            <ChevronRightIcon class="h-4 w-4" />
                        </a>
                    </div>
                </article>
            </div>
        </section>
    </main>
</template>
