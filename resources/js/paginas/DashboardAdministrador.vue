<template>
    <main class="min-h-screen bg-[#f3f1f3]">
        <div class="fixed inset-x-0 top-0 z-30">
            <header-registrado title="Dashboard" />
        </div>

        <NavIzquierda :items="menuLateral" />

        <section class="pl-72 pr-8 pt-32 sm:pr-10">
            <div class="mx-auto flex max-w-5xl flex-col items-start gap-8">
                <div class="flex flex-wrap gap-4">
                    <stats-card
                        icono="/imagenes/iconoUsuarios.png"
                        :iconoType="'image'"
                        label="Clientes"
                        api-url="/api/clientes-count"
                    />

                    <stats-card
                        v-if="esAdministrador"
                        icono="/imagenes/iconoUsuarios.png"
                        :iconoType="'image'"
                        label="Usuarios"
                        api-url="/api/usuarios-count"
                    />
                </div>

                <div class="w-full">
                    <clientes-tabla />
                </div>

                <div v-if="esAdministrador" class="w-full">
                    <usuarios-tabla />
                </div>
            </div>
        </section>
    </main>
</template>

<script setup>
import { ClipboardDocumentListIcon, FolderIcon } from '@heroicons/vue/24/outline';
import NavIzquierda from '../components/Navizquierda.vue';

const propiedades = defineProps({
    tipoMenu: {
        type: String,
        default: 'admin',
    },
});

const menuAdministrador = [
    {
        id: 'dashboard',
        label: 'Dashboard',
        icon: '/imagenes/casita.png',
        path: '/dashboard-admin',
        iconType: 'image',
    },
    {
        id: 'anadir-cliente',
        label: 'Añadir cliente',
        icon: '/imagenes/cliente.png',
        path: '/anadir-cliente',
        iconType: 'image',
    },
   
];

const menuOperador = [
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
        path: '/dashboard-admin',
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

const menuLateral = propiedades.tipoMenu === 'admin' ? menuAdministrador : menuOperador;
const esAdministrador = propiedades.tipoMenu === 'admin';
</script>

<style lang="scss" scoped>
</style>
