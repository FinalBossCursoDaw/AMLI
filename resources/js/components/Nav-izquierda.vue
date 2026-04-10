<script setup lang="ts">
import { ref } from 'vue';

interface MenuItem {
    id: string;
    label: string;
    icon: string;
    path: string;
}

const menuItems = ref<MenuItem[]>([
    {
        id: 'dashboard',
        label: 'Dashboard',
        icon: 'home',
        path: '/dashboard'
    },
    {
        id: 'clientes',
        label: 'Clientes',
        icon: 'people',
        path: '/clientes'
    }
]);

const isActive = (path: string) => {
    return window.location.pathname === path;
};

const getIcon = (iconName: string) => {
    const icons: Record<string, string> = {
        home: '🏠',
        people: '👥',
        settings: '⚙️',
        logout: '🚪'
    };
    return icons[iconName] || '📌';
};
</script>

<template>
    <aside class="fixed left-0 top-0 h-screen w-48 bg-gradient-to-b from-[#cb0c14] to-[#a00a0f] shadow-lg flex flex-col">
        
        <!-- Logo Section -->
        <div class="flex items-center justify-center py-8 px-4 border-b-2 border-white border-opacity-20">
            <img 
                src="/imagenes/logo-amli.png" 
                alt="AMLI Logistics" 
                class="h-16 w-auto"
            />
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 py-8 px-0">
            <ul class="space-y-0">
                <li v-for="item in menuItems" :key="item.id">
                    <a
                        :href="item.path"
                        :class="[
                            'flex items-center px-6 py-4 text-white transition-all duration-300',
                            'hover:bg-white hover:bg-opacity-20',
                            isActive(item.path) ? 'bg-white bg-opacity-25 border-r-4 border-white' : 'border-r-4 border-transparent'
                        ]"
                    >
                        <span class="text-2xl mr-4">{{ getIcon(item.icon) }}</span>
                        <span class="font-montserrat font-semibold text-base">{{ item.label }}</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Footer Section (Optional - for logout or user info) -->
        <div class="py-6 px-6 border-t-2 border-white border-opacity-20">
            <button 
                class="w-full flex items-center justify-center py-3 px-4 rounded-lg bg-white bg-opacity-20 text-white font-montserrat font-semibold hover:bg-opacity-30 transition-all duration-300"
            >
                <span class="mr-2">🚪</span>
                Cerrar sesión
            </button>
        </div>
    </aside>

    <!-- Spacer for main content -->
    <div class="ml-48"></div>
</template>

<style scoped>
/* Smooth transitions for active states */
a {
    transition: background-color 0.3s ease, border-color 0.3s ease;
}
</style>
