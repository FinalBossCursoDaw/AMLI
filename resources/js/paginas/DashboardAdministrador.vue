<template>
    <main class="amli-page">
        <div class="fixed inset-x-0 top-0 z-30">
            <header-registrado title="Dashboard" />
        </div>

        <NavIzquierda :items="menuLateral" />

        <section class="pl-72 pr-8 pt-40 sm:pr-10 lg:pt-44">
            <div class="mx-auto flex max-w-5xl flex-col items-start gap-8">
                <section class="amli-hero w-full">
                    <div class="amli-hero-content grid gap-5 lg:grid-cols-[1.45fr_1fr] lg:items-end">
                        <div>
                            <p class="font-montserrat text-[11px] font-bold uppercase tracking-[0.28em] text-[#cb0c14]">Administracion</p>
                            <h1 class="mt-2 font-montserrat text-[34px] font-extrabold leading-tight text-[#2f2b2c]">
                                Gestion central de clientes y usuarios
                            </h1>
                            <p class="mt-3 max-w-[58ch] font-montserrat text-[14px] leading-6 text-[#625b5e]">
                                Panel enfocado en altas, permisos y mantenimiento de datos principales.
                            </p>
                        </div>

                        <div class="amli-metric-card">
                            <p class="font-montserrat text-[11px] font-semibold uppercase tracking-[0.12em] text-[#9f9699]">Modulo</p>
                            <p class="mt-1 font-montserrat text-[20px] font-extrabold text-[#cb0c14]">Backoffice AMLI</p>
                        </div>
                    </div>
                </section>

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
        path: '/operaciones',
        iconType: 'component',
        iconComponent: FolderIcon,
    },
];

const menuLateral = propiedades.tipoMenu === 'admin' ? menuAdministrador : menuOperador;
const esAdministrador = propiedades.tipoMenu === 'admin';
</script>

<style lang="scss" scoped>
</style>
