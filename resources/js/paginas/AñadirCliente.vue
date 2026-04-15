<script setup lang="ts">
import { ClipboardDocumentListIcon, FolderIcon } from '@heroicons/vue/24/outline';
import HeaderRegistrado from '@/components/Header-registrado.vue';
import NavIzquierda from '../components/Navizquierda.vue';
import FormAnadirCliente from '@/components/Form-AnadirCliente.vue';
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
        iconType: 'image'
    },
    {
        id: 'anadir-cliente',
        label: 'Anadir cliente',
        icon: '/imagenes/cliente.png',
        path: '/anadir-cliente',
        iconType: 'image'
    },
    {
        id: 'editar-cliente',
        label: 'Editar cliente',
        icon: '/imagenes/cliente.png',
        path: '/editar-cliente',
        iconType: 'image'
    }
];

const menuOperador: MenuItem[] = [
    {
        id: 'dashboard',
        label: 'Dashboard',
        icon: '/imagenes/casita.png',
        path: '/dashboard-operador-cliente',
        iconType: 'image'
    },
    {
        id: 'clientes',
        label: 'Clientes',
        icon: '/imagenes/cliente.png',
        path: '/dashboard-admin',
        iconType: 'image'
    },
    {
        id: 'ofertas',
        label: 'Ofertas',
        icon: '',
        path: '/ofertas',
        iconType: 'component',
        iconComponent: ClipboardDocumentListIcon
    },
    {
        id: 'operaciones',
        label: 'Operaciones',
        icon: '',
        path: '/operaciones',
        iconType: 'component',
        iconComponent: FolderIcon
    }
];

const menuLateral = propiedades.tipoMenu === 'admin' ? menuAdministrador : menuOperador;
</script>

<template>
    <div class="min-h-screen bg-[#f3f1f3]">
        <div class="fixed inset-x-0 top-0 z-30">
            <HeaderRegistrado title="Anadir cliente" />
        </div>

        <NavIzquierda :items="menuLateral" />

        <section class="pl-72 pr-8 pt-40 sm:pr-10 lg:pt-44">
            <FormAnadirCliente />
        </section>
    </div>
</template>
