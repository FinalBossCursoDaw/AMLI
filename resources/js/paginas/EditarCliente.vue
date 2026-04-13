<script setup lang="ts">
import { ClipboardDocumentListIcon, FolderIcon } from '@heroicons/vue/24/outline';
import HeaderRegistrado from '../components/Header-registrado.vue';
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
        path: '/anadir-cliente',
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
        path: '/anadir-cliente',
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
</script>

<template>
    <main class="min-h-screen bg-[#f3f1f3]">
        <div class="fixed inset-x-0 top-0 z-30">
            <HeaderRegistrado
                title="Editar Cliente"
                subtitle="Modifica la informacion del cliente y gestiona su acceso"
            />
        </div>

        <NavIzquierda :items="menuLateral" />

        <section class="pl-72 pr-8 pt-32 sm:pr-10">
            <div class="mx-auto max-w-5xl">
                <div class="mb-5 rounded-lg border border-[#ded8da] bg-white px-5 py-4 shadow-sm">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex flex-wrap items-center gap-4 text-[11px] text-[#8b8688]">
                            <div class="rounded border border-[#d8d2d4] bg-[#fbfafb] px-3 py-1.5 font-montserrat font-medium text-[#504c4d]">
                                ID: CLI-000001
                            </div>
                            <p class="font-montserrat">Fecha de alta: 16/11/2025</p>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="font-montserrat text-[11px] text-[#7b7778]">Estado:</span>
                            <span class="rounded-full bg-[#4f815d] px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.08em] text-white">
                                Activo
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-[1.15fr_0.95fr]">
                    <section class="rounded-lg border border-[#d9d2d5] bg-white shadow-sm">
                        <div class="border-b border-[#e6e0e2] px-5 py-4">
                            <h2 class="font-montserrat text-[16px] font-semibold text-[#383536]">Datos del cliente</h2>
                        </div>

                        <div class="space-y-6 px-5 py-5">
                            <div class="space-y-3">
                                <div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
                                    <label class="font-montserrat text-[11px] text-[#5f5a5b]">Nombre de empresa</label>
                                    <input
                                        type="text"
                                        value="Poliercics"
                                        class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                                    />
                                </div>

                                <div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
                                    <label class="font-montserrat text-[11px] text-[#5f5a5b]">NIF o CIF</label>
                                    <input
                                        type="text"
                                        value="49013151P"
                                        class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                                    />
                                </div>

                                <div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
                                    <label class="font-montserrat text-[11px] text-[#5f5a5b]">Pais</label>
                                    <select class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]">
                                        <option selected>Alemania</option>
                                        <option>Espana</option>
                                        <option>Francia</option>
                                    </select>
                                </div>

                                <div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
                                    <label class="font-montserrat text-[11px] text-[#5f5a5b]">Direccion</label>
                                    <input
                                        type="text"
                                        value="Calle Ficticia 125"
                                        class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                                    />
                                </div>

                                <div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
                                    <label class="font-montserrat text-[11px] text-[#5f5a5b]">Ciudad</label>
                                    <select class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]">
                                        <option selected>Berlin</option>
                                        <option>Munich</option>
                                        <option>Hamburgo</option>
                                    </select>
                                </div>

                                <div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
                                    <label class="font-montserrat text-[11px] text-[#5f5a5b]">Codigo postal</label>
                                    <input
                                        type="text"
                                        value="10015"
                                        class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                                    />
                                </div>
                            </div>

                            <div class="border-t border-[#ebe6e8] pt-5">
                                <h3 class="mb-3 font-montserrat text-[14px] font-semibold text-[#383536]">Datos del contacto</h3>

                                <div class="space-y-3">
                                    <div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
                                        <label class="font-montserrat text-[11px] text-[#5f5a5b]">Contacto</label>
                                        <input
                                            type="text"
                                            value="Juan Perez"
                                            class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                                        />
                                    </div>

                                    <div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
                                        <label class="font-montserrat text-[11px] text-[#5f5a5b]">Email</label>
                                        <input
                                            type="email"
                                            value="jperez1223@poliercics.barcelona"
                                            class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                                        />
                                    </div>

                                    <div class="grid gap-3 sm:grid-cols-[140px_1fr] sm:items-center">
                                        <label class="font-montserrat text-[11px] text-[#5f5a5b]">Telefono</label>
                                        <input
                                            type="text"
                                            value="699345245"
                                            class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-lg border border-[#d9d2d5] bg-white shadow-sm">
                        <div class="border-b border-[#e6e0e2] px-5 py-4">
                            <h2 class="font-montserrat text-[16px] font-semibold text-[#383536]">Accesos y permisos</h2>
                        </div>

                        <div class="space-y-5 px-5 py-5">
                            <div class="space-y-3">
                                <div class="grid gap-3 sm:grid-cols-[104px_1fr] sm:items-center">
                                    <label class="font-montserrat text-[11px] text-[#5f5a5b]">Usuario</label>
                                    <input
                                        type="text"
                                        value="Juanperez"
                                        class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                                    />
                                </div>

                                <div class="grid gap-3 sm:grid-cols-[104px_1fr] sm:items-center">
                                    <label class="font-montserrat text-[11px] text-[#5f5a5b]">Contrasena</label>
                                    <input
                                        type="text"
                                        value="SoyJuan"
                                        class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]"
                                    />
                                </div>

                                <div class="grid gap-3 sm:grid-cols-[104px_1fr] sm:items-center">
                                    <label class="font-montserrat text-[11px] text-[#5f5a5b]">Rol</label>
                                    <select class="h-8 rounded-[4px] border border-[#d6d0d2] px-3 font-montserrat text-[11px] text-[#333132] outline-none focus:border-[#b4acad]">
                                        <option selected>Cliente</option>
                                        <option>Administrador</option>
                                        <option>Gestor</option>
                                    </select>
                                </div>
                            </div>

                            <div class="border-t border-[#ebe6e8] pt-5">
                                <h3 class="mb-4 font-montserrat text-[14px] font-semibold text-[#383536]">Estado del usuario</h3>

                                <div class="mb-5 flex items-center justify-between gap-4">
                                    <span class="font-montserrat text-[11px] text-[#5f5a5b]">Usuario Activo</span>

                                    <button
                                        type="button"
                                        class="relative h-6 w-11 rounded-full bg-[#f44336] transition"
                                    >
                                        <span class="absolute right-1 top-1 h-4 w-4 rounded-full bg-white shadow-sm"></span>
                                    </button>
                                </div>

                                <button
                                    type="button"
                                    class="rounded-[4px] bg-[#f1efef] px-4 py-2 font-montserrat text-[10px] font-semibold text-[#5b5758] transition hover:bg-[#e6e1e2]"
                                >
                                    Restablecer contrasena
                                </button>
                            </div>

                            <div class="border-t border-[#ebe6e8] pt-5">
                                <div class="flex justify-end gap-3">
                                    <button
                                        type="button"
                                        class="rounded-[4px] border border-[#d8d2d4] bg-white px-5 py-2 font-montserrat text-[11px] font-semibold text-[#5b5758] transition hover:bg-[#f5f3f4]"
                                    >
                                        Cancelar
                                    </button>

                                    <button
                                        type="button"
                                        class="rounded-[4px] bg-[#5b8a61] px-5 py-2 font-montserrat text-[11px] font-semibold text-white shadow-sm transition hover:bg-[#507b56]"
                                    >
                                        Guardar cambios
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </main>
</template>

<style lang="scss" scoped>
</style>
