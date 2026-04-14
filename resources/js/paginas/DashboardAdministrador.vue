<template>
    <main class="min-h-screen bg-[#f3f1f3]">
        <div class="fixed inset-x-0 top-0 z-30">
            <header-registrado title="Dashboard" />
        </div>

        <NavIzquierda :items="menuItems" />

        <section class="pl-72 pr-8 pt-40 sm:pr-10 lg:pt-44">
            <div class="mx-auto flex max-w-5xl flex-col items-start gap-8">
                <div class="w-fit">
                    <stats-card
                        icono="/imagenes/iconoUsuarios.png"
                        :iconoType="'image'"
                        label="Clientes"
                        api-url="/api/clientes-count"
                    />
                </div>

                <div class="w-full">
                    <clientes-tabla />
                </div>
            </div>
        </section>
    </main>
</template>

<script setup lang="ts">
import { ClipboardDocumentListIcon, FolderIcon } from '@heroicons/vue/24/outline';
import NavIzquierda from '../components/Navizquierda.vue';
import type { Component } from 'vue';

interface MenuItem {
    id: string;
    label: string;
    icon: string;
    path: string;
    iconType: 'image' | 'emoji' | 'component';
    iconComponent?: Component;
}

const propiedades = defineProps<{
    tipoMenu?: string;
}>();

const menuAdministrador: MenuItem[] = [
    {
        id: 'dashboard',
        label: 'Dashboard',
        icon: '/imagenes/casita.png',
        path: '/dashboard-admin',
        iconType: 'image',
    },
    {
        id: 'clientes',
        label: 'Clientes',
        icon: '/imagenes/cliente.png',
        path: '/clientes',
        iconType: 'image',
    },
];

const menuOperador: MenuItem[] = [
    {
        id: 'dashboard',
        label: 'Dashboard',
        icon: '/imagenes/casita.png',
        path: '/dashboard-operador-cliente',
        iconType: 'image',
    },
    {
        id: 'clientes',
        label: 'Clientes',
        icon: '/imagenes/cliente.png',
        path: '/clientes',
        iconType: 'image',
    },
    {
        id: 'ofertas',
        label: 'Ofertas',
        icon: '',
        path: '/ofertas',
        iconType: 'component',
        iconComponent: ClipboardDocumentListIcon,
    },
    {
        id: 'operaciones',
        label: 'Operaciones',
        icon: '',
        path: '/dashboard-operador-cliente#operaciones',
        iconType: 'component',
        iconComponent: FolderIcon,
    },
];

const menuItems = propiedades.tipoMenu === 'operador' ? menuOperador : menuAdministrador;
</script>

<style lang="scss" scoped>
</style>
