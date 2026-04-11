<script setup lang="ts">
import HeaderRegistrado from '@/components/Header-registrado.vue';
import NavIzquierda from '../components/Navizquierda.vue';
import FormAnadirCliente from '@/components/Form-AnadirCliente.vue';

interface MenuItem {
    id: string;
    label: string;
    icon: string;
    path: string;
    iconType: 'image' | 'emoji';
}

const menuItems: MenuItem[] = [
    {
        id: 'dashboard',
        label: 'Dashboard',
        icon: '/imagenes/casita.png',
        path: '/dashboard-admin',
        iconType: 'image'
    },
    {
        id: 'clientes',
        label: 'Clientes',
        icon: '/imagenes/cliente.png',
        path: '/clientes',
        iconType: 'image'
    }
];
</script>

<template>
    <HeaderRegistrado title="Añadir cliente" />
    <div class="min-h-screen bg-[#f3f1f3]">
        <NavIzquierda :items="menuItems" />
        <FormAnadirCliente />
    </div>
</template>
