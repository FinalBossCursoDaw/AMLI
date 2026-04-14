<script setup>
import { ClipboardDocumentListIcon, FolderIcon } from '@heroicons/vue/24/outline';
import NavIzquierda from '../components/Navizquierda.vue';

const menuOperativo = [
    { id: 'dashboard', label: 'Dashboard', icon: '/imagenes/casita.png', path: '/dashboard-operador-cliente', iconType: 'image' },
    { id: 'clientes', label: 'Clientes', icon: '/imagenes/cliente.png', path: '/dashboard-admin', iconType: 'image' },
    { id: 'ofertas', label: 'Ofertas', icon: '', path: '/ofertas', iconType: 'component', iconComponent: ClipboardDocumentListIcon },
    { id: 'operaciones', label: 'Operaciones', icon: '', path: '/operaciones', iconType: 'component', iconComponent: FolderIcon },
];
</script>

<template>
    <main class="min-h-screen bg-[#f3f1f3]">
        <div class="fixed inset-x-0 top-0 z-30">
            <header-registrado title="Ofertas" subtitle="Consulta y gestiona tus ofertas" />
        </div>

        <NavIzquierda :items="menuOperativo" />

        <section class="pl-72 pr-8 pt-40 sm:pr-10 lg:pt-44">
            <div class="mx-auto max-w-[1080px] space-y-8">
                <filtros-ofertas />
                <tabla-ofertas />
            </div>
        </section>
    </main>
</template>
