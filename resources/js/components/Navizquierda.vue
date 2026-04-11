quiero<script setup lang="ts">
import { computed } from 'vue';

interface MenuItem {
    id: string;
    label: string;
    icon: string; // URL de imagen o emoji
    path: string;
    iconType?: 'image' | 'emoji'; // tipo de icono (por defecto 'emoji')
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
    return window.location.pathname === path;
};

const isImageIcon = (item: MenuItem) => {
    return item.iconType === 'image' || item.icon.startsWith('/') || item.icon.startsWith('http');
};
</script>

<template>
    <aside class="fixed left-0 top-0 h-screen w-56 bg-gradient-to-b from-[#cb0c14] to-[#a00a0f] shadow-lg flex flex-col">
      
        <!-- Espaciador superior -->
        <div class="flex-none h-40"></div>

        <!-- Navigation Menu -->
        <nav class="flex-1 py-8 px-0">
            <ul class="space-y-0">
                <li v-for="item in props.items" :key="item.id">
                    <a
                        :href="item.path"
                        :class="[
                            'flex items-center px-4 py-4 text-white transition-all duration-300',
                            'hover:bg-white hover:bg-opacity-20',
                            isActive(item.path) ? 'bg-white bg-opacity-25 border-r-4 border-white' : 'border-r-4 border-transparent'
                        ]"
                    >
                        <!-- Icono: Imagen o Emoji -->
                        <div class="mr-3 flex-shrink-0">
                            <img 
                                v-if="isImageIcon(item)"
                                :src="item.icon"
                                :alt="item.label"
                                class="h-6 w-6 object-contain"
                            />
                            <span v-else class="text-2xl">{{ item.icon }}</span>
                        </div>
                        
                        <!-- Etiqueta -->
                        <span class="font-montserrat font-semibold text-base">{{ item.label }}</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Footer Section (Optional - for logout or user info) -->
        <div class="py-4 px-4 border-t-2 border-white border-opacity-20">
            <button 
                class="w-full flex items-center justify-center py-2 px-3 rounded-lg bg-white bg-opacity-20 text-white font-montserrat font-semibold hover:bg-opacity-30 transition-all duration-300 text-sm"
            >
                <span class="mr-2">🚪</span>
                Cerrar sesión
            </button>
        </div>
    </aside>

    <!-- Ancho -->
    <div class="ml-56"></div>
</template>

<style scoped>
/* Smooth transitions for active states */
a {
    transition: background-color 0.3s ease, border-color 0.3s ease;
}
</style>
