<script setup lang="ts">
import { ArrowLeftOnRectangleIcon } from '@heroicons/vue/24/outline';
import type { Component } from 'vue';

interface MenuItem {
    id: string;
    label: string;
    icon: string;
    path: string;
    iconType?: 'image' | 'emoji' | 'component';
    iconComponent?: Component;
}

interface Props {
    items?: MenuItem[];
}

const props = withDefaults(defineProps<Props>(), {
    items: () => [
        {
            id: 'dashboard',
            label: 'Dashboard',
            icon: '🏠',
            path: '/dashboard-admin',
            iconType: 'emoji'
        },
        {
            id: 'clientes',
            label: 'Clientes',
            icon: '👥',
            path: '/clientes',
            iconType: 'emoji'
        }
    ]
});

const isActive = (path: string) => {
    return window.location.pathname === path || window.location.pathname.startsWith(`${path}/`);
};

const isImageIcon = (item: MenuItem) => {
    return item.iconType === 'image' || item.icon.startsWith('/') || item.icon.startsWith('http');
};

const isComponentIcon = (item: MenuItem) => {
    return item.iconType === 'component' && !!item.iconComponent;
};
</script>

<template>
    <aside class="fixed left-0 top-0 flex h-screen w-56 flex-col bg-gradient-to-b from-[#cb0c14] to-[#a00a0f] shadow-lg">
        <div class="flex-none h-40"></div>

        <nav class="flex-1 px-0 py-8">
            <ul class="space-y-0">
                <li v-for="item in props.items" :key="item.id">
                    <a
                        :href="item.path"
                        :class="[
                            'flex items-center px-4 py-4 transition-all duration-300',
                            'hover:bg-white hover:bg-opacity-20 hover:text-white',
                            isActive(item.path) ? 'border-r-4 border-white bg-white bg-opacity-25 text-white' : 'border-r-4 border-transparent text-white/70'
                        ]"
                    >
                        <div class="mr-3 flex-shrink-0">
                            <component
                                :is="item.iconComponent"
                                v-if="isComponentIcon(item)"
                                :class="['h-6 w-6', isActive(item.path) ? 'text-white' : 'text-white/70']"
                            />
                            <img
                                v-else-if="isImageIcon(item)"
                                :src="item.icon"
                                :alt="item.label"
                                :class="['h-6 w-6 object-contain', isActive(item.path) ? 'opacity-100' : 'opacity-70']"
                            />
                            <span v-else :class="['text-2xl', isActive(item.path) ? 'text-white' : 'text-white/70']">{{ item.icon }}</span>
                        </div>

                        <span :class="['font-montserrat text-base font-semibold', isActive(item.path) ? 'text-white' : 'text-white/70']">{{ item.label }}</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="border-t-2 border-white border-opacity-20 px-4 py-4">
            <button
                class="w-full flex items-center justify-center rounded-lg bg-white bg-opacity-20 px-3 py-2 text-sm font-montserrat font-semibold text-white transition-all duration-300 hover:bg-opacity-30"
            >
                <ArrowLeftOnRectangleIcon class="mr-2 h-5 w-5 text-white" />
                Cerrar sesión
            </button>
        </div>
    </aside>

    <div class="ml-56"></div>
</template>

<style scoped>
a {
    transition: background-color 0.3s ease, border-color 0.3s ease;
}
</style>
