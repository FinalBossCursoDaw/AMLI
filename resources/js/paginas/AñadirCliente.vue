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
        label: 'Añadir cliente',
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
        path: '/dashboard-operador-cliente#operaciones',
        iconType: 'component',
        iconComponent: FolderIcon
    }
];

const menuLateral = propiedades.tipoMenu === 'admin' ? menuAdministrador : menuOperador;
</script>

<template>
    <HeaderRegistrado title="Añadir cliente" />
    <div class="min-h-screen bg-[#f3f1f3]">
        <NavIzquierda :items="menuLateral" />
        <FormAnadirCliente />
    </div>
</template>
