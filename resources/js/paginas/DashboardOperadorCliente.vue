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
    <main class="min-h-screen bg-[#f3f1f3]">
        <div class="fixed inset-x-0 top-0 z-30">
            <header-registrado title="Dashboard" subtitle="Resumen de tu actividad" />
        </div>

        <NavIzquierda :items="menuItems" />

        <section class="pl-72 pr-8 pt-40 sm:pr-10 lg:pt-44">
            <div class="mx-auto max-w-[1080px]">
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
