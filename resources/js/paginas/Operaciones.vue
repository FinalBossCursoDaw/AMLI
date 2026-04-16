<script setup>
import { ClipboardDocumentListIcon, FolderIcon } from '@heroicons/vue/24/outline';
import { computed, ref, onMounted } from 'vue';
import HeaderRegistrado from '../components/Header-registrado.vue';
import NavIzquierda from '../components/Navizquierda.vue';
import FiltrosOperaciones from '../components/operaciones/FiltrosOperaciones.vue';
import TablaOperaciones from '../components/operaciones/TablaOperaciones.vue';

const menuOperativo = [
    { id: 'dashboard', label: 'Dashboard', icon: '/imagenes/casita.png', path: '/dashboard-operador-cliente', iconType: 'image' },
    { id: 'clientes', label: 'Clientes', icon: '/imagenes/cliente.png', path: '/dashboard-admin', iconType: 'image' },
    { id: 'ofertas', label: 'Ofertas', icon: '', path: '/ofertas', iconType: 'component', iconComponent: ClipboardDocumentListIcon },
    { id: 'operaciones', label: 'Operaciones', icon: '', path: '/operaciones', iconType: 'component', iconComponent: FolderIcon },
];

const operaciones = ref([]);
const cargando = ref(true);
const error = ref(null);

const filtros = ref({
    id: '',
    cliente: '',
    tipo: '',
    origen: '',
    incoterm: '',
    modo: '',
    estado: '',
    busqueda: '',
});

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

const obtenerOpcionesUnicas = (campo) => {
    return [...new Set(operaciones.value.map((operacion) => operacion[campo]))];
};

const opcionesFiltros = computed(() => ({
    ids: obtenerOpcionesUnicas('id'),
    clientes: obtenerOpcionesUnicas('cliente'),
    tipos: obtenerOpcionesUnicas('tipo'),
    origenes: obtenerOpcionesUnicas('origen'),
    incoterms: obtenerOpcionesUnicas('incoterm'),
    modos: obtenerOpcionesUnicas('modo'),
    estados: obtenerOpcionesUnicas('estado'),
}));

const operacionesFiltradas = computed(() => {
    const texto = filtros.value.busqueda.trim().toLowerCase();

    return operaciones.value.filter((operacion) => {
        const coincideBusqueda =
            !texto ||
            [
                operacion.id,
                operacion.cliente,
                operacion.tipo,
                operacion.origen,
                operacion.destino,
                operacion.incoterm,
                operacion.modo,
                operacion.estado,
            ].some((valor) => valor?.toLowerCase().includes(texto));

        return coincideBusqueda &&
            (!filtros.value.id || operacion.id === filtros.value.id) &&
            (!filtros.value.cliente || operacion.cliente === filtros.value.cliente) &&
            (!filtros.value.tipo || operacion.tipo === filtros.value.tipo) &&
            (!filtros.value.origen || operacion.origen === filtros.value.origen) &&
            (!filtros.value.incoterm || operacion.incoterm === filtros.value.incoterm) &&
            (!filtros.value.modo || operacion.modo === filtros.value.modo) &&
            (!filtros.value.estado || operacion.estado === filtros.value.estado);
    });
});

const totalPaginas = computed(() => {
    return Math.max(1, Math.ceil(operacionesFiltradas.value.length / porPagina));
});

const operacionesPaginadas = computed(() => {
    const inicio = (paginaActual.value - 1) * porPagina;
    return operacionesFiltradas.value.slice(inicio, inicio + porPagina);
});

const actualizarFiltros = (nuevosFiltros) => {
    filtros.value = nuevosFiltros;
    paginaActual.value = 1;
};

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
                    <FiltrosOperaciones
                        :filtros="filtros"
                        :opciones="opcionesFiltros"
                        @update:filtros="actualizarFiltros"
                    />

                    <TablaOperaciones
                        :operaciones="operacionesPaginadas"
                        :pagina-actual="paginaActual"
                        :total-paginas="totalPaginas"
                        :total-registros="operacionesFiltradas.length"
                        :por-pagina="porPagina"
                        @cambiar-pagina="cambiarPagina"
                    />
                </template>
            </div>
        </section>
    </main>
</template>
