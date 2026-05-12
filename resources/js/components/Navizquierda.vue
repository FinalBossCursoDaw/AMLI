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
    <aside class="fixed left-0 top-0 z-20 flex h-screen w-56 flex-col bg-gradient-to-b from-[#c90f17] via-[#b20d13] to-[#8f090d] shadow-[8px_0_28px_rgba(48,48,48,0.18)]">
        <div class="flex h-40 flex-none items-end px-6 pb-5">
            <div>
                <p class="font-montserrat text-[12px] font-semibold uppercase tracking-[0.22em] text-white/65">AMLI</p>
                <div class="mt-2 h-1 w-10 rounded-full bg-white/80"></div>
            </div>
        </div>

        <nav class="flex-1 px-3 py-8">
            <ul class="space-y-2">
                <li v-for="item in props.items" :key="item.id">
                    <a
                        :href="item.path"
                        :class="[
                            'group flex items-center rounded-lg px-4 py-3 transition-all duration-300',
                            'hover:bg-white/16 hover:text-white',
                            isActive(item.path) ? 'bg-white/22 text-white shadow-[inset_3px_0_0_rgba(255,255,255,0.95)]' : 'text-white/72'
                        ]"
                    >
                        <div class="mr-3 flex-shrink-0">
                            <component
                                :is="item.iconComponent"
                                v-if="isComponentIcon(item)"
                                :class="['h-6 w-6 transition', isActive(item.path) ? 'text-white' : 'text-white/72 group-hover:text-white']"
                            />
                            <img
                                v-else-if="isImageIcon(item)"
                                :src="item.icon"
                                :alt="item.label"
                                :class="['h-6 w-6 object-contain transition', isActive(item.path) ? 'opacity-100' : 'opacity-75 group-hover:opacity-100']"
                            />
                            <span v-else :class="['text-2xl transition', isActive(item.path) ? 'text-white' : 'text-white/72 group-hover:text-white']">{{ item.icon }}</span>
                        </div>

                        <span :class="['font-montserrat text-[15px] font-semibold', isActive(item.path) ? 'text-white' : 'text-white/72 group-hover:text-white']">{{ item.label }}</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="border-t border-white/18 px-4 py-4">
            <button
                class="flex w-full items-center justify-center rounded-lg bg-white/16 px-3 py-2.5 font-montserrat text-sm font-semibold text-white transition-all duration-300 hover:bg-white/24"
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
