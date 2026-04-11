<template>
    <main class="min-h-screen bg-[#f3f1f3]">
        <div class="fixed inset-x-0 top-0 z-30">
            <header-registrado title="Dashboard" />
        </div>

        <NavIzquierda :items="menuItems" />

        <section class="pl-72 pr-8 pt-32 sm:pr-10">
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

<script setup>
import NavIzquierda from '../components/Navizquierda.vue';

const menuItems = [
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
</script>

<style lang="scss" scoped>
</style>
