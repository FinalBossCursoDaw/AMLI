<script setup>
import { ArrowUpTrayIcon, ClipboardDocumentListIcon, FolderIcon, PlusIcon } from '@heroicons/vue/24/outline';
import HeaderRegistrado from '../components/Header-registrado.vue';
import NavIzquierda from '../components/Navizquierda.vue';





const menuItems = [
    { id: 'dashboard', label: 'Dashboard', icon: '/imagenes/casita.png', path: '/dashboard-operador-cliente', iconType: 'image' },
    { id: 'clientes', label: 'Clientes', icon: '/imagenes/cliente.png', path: '/anadir-cliente', iconType: 'image' },
    { id: 'ofertas', label: 'Ofertas', icon: '', path: '/dashboard-operador-cliente#ofertas', iconType: 'component', iconComponent: ClipboardDocumentListIcon },
    { id: 'operaciones', label: 'Operaciones', icon: '', path: '/dashboard-operador-cliente#operaciones', iconType: 'component', iconComponent: FolderIcon },
];

const offerRows = [
    { id: 'ITU0041', type: 'FOB', origin: 'Barcelona - Marruecos', destination: 'Barcelona', status: 'Espera', date: '16/11/2025' },
    { id: 'ITU0047', type: 'CIF', origin: 'Barcelona - Bali', destination: 'Bali', status: 'Aceptada', date: '11/11/2025' },
    { id: 'ITU0142', type: 'EX WORKS', origin: 'Barcelona - Islandia', destination: 'Islandia', status: 'Rechazada', date: '07/11/2025' },
    { id: 'ITU0021', type: 'CIF', origin: 'Barcelona - Santorini', destination: 'Santorini', status: 'Borrador', date: '11/11/2025' },
];

const operationRows = [
    { id: 'OP-00056', client: 'Textil BCN S.L.', type: 'Exportacion', incoterm: 'FOB', status: 'Carrier' },
    { id: 'OP-00042', client: 'ElectroNova S.A.', type: 'Importacion', incoterm: 'CIF', status: 'Seller' },
    { id: 'OP-00012', client: 'Maritim Foods', type: 'Exportacion', incoterm: 'EXW', status: 'Carrier' },
];

const notifications = [
    { id: 1, icon: '🔄', color: 'bg-[#4d78ff]', text: 'La operacion OP-00098 se ha actualizado al estado' },
    { id: 2, icon: '✕', color: 'bg-[#f44336]', text: 'La oferta #00023 ha sido rechazada' },
    { id: 3, icon: '+', color: 'bg-[#5b8a61]', text: 'Nueva operacion creada: OP-00101' },
    { id: 4, icon: '⚠', color: 'bg-[#f1b645]', text: 'Incidencia abierta en la operacion OP-0095' },
];

const statusClass = (status) => {
    const classes = {
        Espera: 'bg-[#ffd96d] text-[#7e5f00]',
        Aceptada: 'bg-[#8fdb98] text-[#1f6d2d]',
        Rechazada: 'bg-[#ff9696] text-[#8b1f1f]',
        Borrador: 'bg-[#ff4747] text-white',
        Carrier: 'bg-[#dadde4] text-[#666e79]',
        Seller: 'bg-[#efebec] text-[#7a7476]',
    };

    return classes[status] || 'bg-[#efebec] text-[#6a6566]';
};
</script>

<template>
    <main class="min-h-screen bg-[#f3f1f3]">
        <div class="fixed inset-x-0 top-0 z-30">
            <HeaderRegistrado title="Dashboard" subtitle="Resumen de tu actividad" />
        </div>

        <NavIzquierda :items="menuItems" />

        <section class="pl-72 pr-8 pt-32 sm:pr-10">
            <div class="mx-auto max-w-[1080px]">
                <div class="mb-5 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div class="flex flex-wrap gap-4">
                        <div class="flex min-w-[160px] items-center gap-3 rounded-lg border border-[#ded8da] bg-white px-4 py-3 shadow-sm">
                            <div class="text-[24px] text-[#f0ab33]">✈</div>
                            <div>
                                <p class="font-montserrat text-[11px] font-semibold text-[#474344]">Ofertas enviadas</p>
                                <p class="font-montserrat text-[26px] leading-none text-[#f0ab33]">4</p>
                            </div>
                        </div>

                        <div class="flex min-w-[170px] items-center gap-3 rounded-lg border border-[#ded8da] bg-white px-4 py-3 shadow-sm">
                            <div class="text-[#5b8a61]">
                                <ClipboardDocumentListIcon class="h-7 w-7" />
                            </div>
                            <div>
                                <p class="font-montserrat text-[11px] font-semibold text-[#474344]">Operaciones en curso</p>
                                <p class="font-montserrat text-[26px] leading-none text-[#5b8a61]">5</p>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-[#ddd7d9] bg-white px-4 py-3 font-montserrat text-[12px] font-medium text-[#5f5a5b] shadow-sm transition hover:bg-[#faf8f9]">
                        <ArrowUpTrayIcon class="h-4 w-4 text-[#5f5a5b]" />
                        Subir archivo
                    </button>
                </div>

                <div class="grid gap-6 lg:grid-cols-[1.8fr_1fr]">
                    <div class="space-y-5">
                        <section class="rounded-lg border border-[#dcd6d8] bg-white shadow-sm">
                            <div class="border-b border-[#ebe6e8] px-5 py-3">
                                <h2 class="font-montserrat text-[16px] font-semibold text-[#353233]">Acciones rápidas</h2>
                            </div>

                            <div class="grid gap-4 p-5 sm:grid-cols-2">
                                <a href="#" class="flex items-center justify-between rounded-lg border border-[#ece7e8] bg-[#fcfbfb] px-4 py-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-[#ff1f1f] text-white">
                                            <PlusIcon class="h-7 w-7" />
                                        </div>
                                        <span class="font-montserrat text-[18px] font-medium text-[#353233]">Crear oferta</span>
                                    </div>
                                    <span class="text-[22px] text-[#353233]">></span>
                                </a>

                                <a href="/anadir-cliente" class="flex items-center justify-between rounded-lg border border-[#ece7e8] bg-[#fcfbfb] px-4 py-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-[#f3b649]">
                                            <img src="/imagenes/cliente.png" alt="Crear cliente" class="h-6 w-6 object-contain" />
                                        </div>
                                        <span class="font-montserrat text-[18px] font-medium text-[#353233]">Crear cliente</span>
                                    </div>
                                    <span class="text-[22px] text-[#353233]">></span>
                                </a>
                            </div>
                        </section>

                        <section class="rounded-lg border border-[#dcd6d8] bg-white shadow-sm">
                            <div class="border-b border-[#ebe6e8] px-5 py-3">
                                <h2 class="font-montserrat text-[16px] font-semibold text-[#353233]">Ofertas recientes</h2>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-[#f8f6f7]">
                                        <tr class="font-montserrat text-[10px] uppercase tracking-[0.04em] text-[#b4adaf]">
                                            <th class="px-3 py-2 text-left font-medium">Nº oferta</th>
                                            <th class="px-3 py-2 text-left font-medium">Incoterms</th>
                                            <th class="px-3 py-2 text-left font-medium">Origen</th>
                                            <th class="px-3 py-2 text-left font-medium">Destino</th>
                                            <th class="px-3 py-2 text-left font-medium">Estado</th>
                                            <th class="px-3 py-2 text-left font-medium">Fecha</th>
                                            <th class="px-3 py-2 text-right font-medium">Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="row in offerRows" :key="row.id" class="border-t border-[#efe9eb] font-montserrat text-[11px] text-[#4a4647]">
                                            <td class="px-3 py-2">{{ row.id }}</td>
                                            <td class="px-3 py-2">{{ row.type }}</td>
                                            <td class="px-3 py-2">{{ row.origin }}</td>
                                            <td class="px-3 py-2">{{ row.destination }}</td>
                                            <td class="px-3 py-2">
                                                <span :class="['inline-flex rounded-full px-2 py-0.5 text-[10px] font-semibold', statusClass(row.status)]">{{ row.status }}</span>
                                            </td>
                                            <td class="px-3 py-2">{{ row.date }}</td>
                                            <td class="px-3 py-2 text-right">
                                                <a href="#" class="rounded bg-[#efebec] px-3 py-1 text-[10px] text-[#686364]">Ver</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <section class="rounded-lg border border-[#dcd6d8] bg-white shadow-sm">
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
                                        <tr v-for="row in operationRows" :key="row.id" class="border-t border-[#efe9eb] font-montserrat text-[11px] text-[#4a4647]">
                                            <td class="px-3 py-2">{{ row.id }}</td>
                                            <td class="px-3 py-2">{{ row.client }}</td>
                                            <td class="px-3 py-2">{{ row.type }}</td>
                                            <td class="px-3 py-2">{{ row.incoterm }}</td>
                                            <td class="px-3 py-2">
                                                <span :class="['inline-flex rounded-full px-2 py-0.5 text-[10px] font-semibold', statusClass(row.status)]">{{ row.status }}</span>
                                            </td>
                                            <td class="px-3 py-2 text-right">
                                                <a href="#" class="rounded bg-[#efebec] px-3 py-1 text-[10px] text-[#686364]">Ver</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                    </div>

                    <aside class="flex flex-col">
                        <section class="rounded-lg border border-[#dcd6d8] bg-white shadow-sm">
                            <div class="border-b border-[#ebe6e8] px-5 py-3">
                                <h2 class="font-montserrat text-[16px] font-semibold text-[#353233]">Últimas notificaciones</h2>
                            </div>

                            <div class="divide-y divide-[#ebe6e8]">
                                <div v-for="notification in notifications" :key="notification.id" class="flex items-center gap-3 px-4 py-4">
                                    <div :class="[notification.color, 'flex h-10 w-10 flex-none items-center justify-center rounded-md text-lg text-white']">
                                        {{ notification.icon }}
                                    </div>
                                    <p class="flex-1 font-montserrat text-[12px] leading-5 text-[#4f4a4b]">{{ notification.text }}</p>
                                    <span class="text-[22px] text-[#353233]">></span>
                                </div>
                            </div>
                        </section>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="#" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-[#ddd7d9] bg-white px-4 py-3 font-montserrat text-[12px] font-medium text-[#5f5a5b] shadow-sm transition hover:bg-[#faf8f9]">
                                Ver todas las ofertas
                                <span class="text-[#ff2424]">></span>
                            </a>

                            <a href="#" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-[#ddd7d9] bg-white px-4 py-3 font-montserrat text-[12px] font-medium text-[#5f5a5b] shadow-sm transition hover:bg-[#faf8f9]">
                                Ver todas las operaciones
                                <span class="text-[#ff2424]">></span>
                            </a>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
    </main>
</template>
