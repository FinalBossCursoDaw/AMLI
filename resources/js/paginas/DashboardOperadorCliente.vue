<script setup>
import { ClipboardDocumentListIcon, FolderIcon } from '@heroicons/vue/24/outline';
import NavIzquierda from '../components/Navizquierda.vue';

const props = defineProps({
    rolId: {
        type: Number,
        required: true,
    },
});

const puedeCrear = props.rolId === 2;

const menuItems = [
    { id: 'dashboard', label: 'Dashboard', icon: '/imagenes/casita.png', path: '/dashboard-operador-cliente', iconType: 'image' },
    { id: 'ofertas', label: 'Ofertas', icon: '', path: '/ofertas', iconType: 'component', iconComponent: ClipboardDocumentListIcon },
    { id: 'operaciones', label: 'Operaciones', icon: '', path: '/operaciones', iconType: 'component', iconComponent: FolderIcon },
];

if (props.rolId === 2) {
    menuItems.splice(1, 0, {
        id: 'clientes',
        label: 'Clientes',
        icon: '/imagenes/cliente.png',
        path: '/dashboard-admin',
        iconType: 'image',
    });
}

</script>

<template>
    <main class="amli-page">
        <div class="fixed inset-x-0 top-0 z-30">
            <header-registrado title="Dashboard" subtitle="Resumen de tu actividad" />
        </div>

        <NavIzquierda :items="menuItems" />

        <section class="pl-72 pr-8 pt-40 sm:pr-10 lg:pt-44">
            <div class="mx-auto max-w-[1080px]">
                <section class="amli-hero mb-6">
                    <div class="amli-hero-content grid gap-5 lg:grid-cols-[1.35fr_1fr] lg:items-end">
                        <div>
                            <p class="font-montserrat text-[11px] font-bold uppercase tracking-[0.28em] text-[#cb0c14]">Centro operativo</p>
                            <h1 class="mt-2 font-montserrat text-[34px] font-extrabold leading-tight text-[#2f2b2c]">
                                Control diario de ofertas, operaciones y avisos
                            </h1>
                            <p class="mt-3 max-w-[58ch] font-montserrat text-[14px] leading-6 text-[#625b5e]">
                                Vista preparada para revisar actividad reciente y actuar rapido sobre los procesos activos.
                            </p>
                        </div>

                        <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-1">
                            <div class="amli-metric-card">
                                <p class="font-montserrat text-[11px] font-semibold uppercase tracking-[0.12em] text-[#9f9699]">Prioridad</p>
                                <p class="mt-1 font-montserrat text-[18px] font-extrabold text-[#cb0c14]">Seguimiento activo</p>
                            </div>
                            <div class="amli-metric-card">
                                <p class="font-montserrat text-[11px] font-semibold uppercase tracking-[0.12em] text-[#9f9699]">Estado</p>
                                <p class="mt-1 font-montserrat text-[18px] font-extrabold text-[#303030]">Operativo</p>
                            </div>
                        </div>
                    </div>
                </section>

                <resumen-operador />

                <div class="grid gap-6 lg:grid-cols-[1.8fr_1fr]">
                    <div class="space-y-5">
                        <acciones-rapidas-operador v-if="puedeCrear" />

                        <ofertas-recientes-operador />
                        <operaciones-recientes-operador />
                    </div>

                    <notificaciones-operador />
                </div>
            </div>
        </section>
    </main>
</template>
