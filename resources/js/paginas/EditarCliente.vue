<script setup lang="ts">
import NavIzquierda from '../components/auth/Navizquierda.vue';

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
        path: '/dashboard',
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
    <div class="min-h-screen bg-[#f3f1f3]">
        <NavIzquierda :items="menuItems" />
    </div>
</template>