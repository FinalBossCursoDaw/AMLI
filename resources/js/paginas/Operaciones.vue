<script setup>
import { ClipboardDocumentListIcon, FolderIcon } from '@heroicons/vue/24/outline';
import { computed, ref, onMounted } from 'vue';
import HeaderRegistrado from '../components/Header-registrado.vue';
import NavIzquierda from '../components/Navizquierda.vue';
import TablaOperaciones from '../components/operaciones/TablaOperaciones.vue';

const props = defineProps({
    rolId: {
        type: Number,
        default: 0,
    },
});

const menuOperativo = computed(() => {
    const items = [
        { id: 'dashboard', label: 'Dashboard', icon: '/imagenes/casita.png', path: '/dashboard-operador-cliente', iconType: 'image' },
        { id: 'ofertas', label: 'Ofertas', icon: '', path: '/ofertas', iconType: 'component', iconComponent: ClipboardDocumentListIcon },
        { id: 'operaciones', label: 'Operaciones', icon: '', path: '/operaciones', iconType: 'component', iconComponent: FolderIcon },
    ];

    if (props.rolId === 2) {
        items.splice(1, 0, {
            id: 'clientes',
            label: 'Clientes',
            icon: '/imagenes/cliente.png',
            path: '/dashboard-admin',
            iconType: 'image',
        });
    }

    return items;
});

const operaciones = ref([]);
const cargando = ref(true);
const error = ref(null);

const paginaActual = ref(1);
const porPagina = 6;

onMounted(async () => {
    try {
        cargando.value = true;
        const response = await fetch('/api/operaciones');
        if (!response.ok) {
            throw new Error('Error al cargar operaciones');
        }
        operaciones.value = await response.json();
    } catch (err) {
        error.value = err.message;
        console.error('Error cargando operaciones:', err);
    } finally {
        cargando.value = false;
    }
});

const totalPaginas = computed(() => {
    return Math.max(1, Math.ceil(operaciones.value.length / porPagina));
});

const operacionesPaginadas = computed(() => {
    const inicio = (paginaActual.value - 1) * porPagina;
    return operaciones.value.slice(inicio, inicio + porPagina);
});

const cambiarPagina = (pagina) => {
    if (pagina < 1 || pagina > totalPaginas.value) {
        return;
    }

    paginaActual.value = pagina;
};
</script>

<template>
    <main class="min-h-screen bg-[#f3f1f3]">
        <div class="fixed inset-x-0 top-0 z-30">
            <HeaderRegistrado title="Operaciones" subtitle="Consulta el estado y tracking de cada operacion" />
        </div>

        <NavIzquierda :items="menuOperativo" />

        <section class="pl-72 pr-8 pt-40 sm:pr-10 lg:pt-44">
            <div class="mx-auto max-w-[1180px] space-y-8">
                <div v-if="error" class="rounded-lg bg-red-50 p-4 text-red-700">
                    Error al cargar operaciones: {{ error }}
                </div>

                <div v-else-if="cargando" class="flex items-center justify-center py-12">
                    <div class="text-gray-500">Cargando operaciones...</div>
                </div>

                <template v-else>
                    <TablaOperaciones
                        :operaciones="operacionesPaginadas"
                        :pagina-actual="paginaActual"
                        :total-paginas="totalPaginas"
                        :total-registros="operaciones.length"
                        :por-pagina="porPagina"
                        @cambiar-pagina="cambiarPagina"
                    />
                </template>
            </div>
        </section>
    </main>
</template>
