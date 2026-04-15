<script setup>
import { ClipboardDocumentListIcon, FolderIcon } from '@heroicons/vue/24/outline';
import { computed, ref } from 'vue';
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

const operaciones = [
    { id: 'OP-2026-001', cliente: 'Importaciones Herrera', tipo: 'Import', origen: 'Valencia', destino: 'New York', incoterm: 'FOB', modo: 'Maritimo', estado: 'Carrier', actualizacion: 'Hace 5m' },
    { id: 'OP-2026-002', cliente: 'Global Logistics', tipo: 'Export', origen: 'Madrid', destino: 'Barcelona', incoterm: 'FOB', modo: 'Terrestre', estado: 'Buyer', actualizacion: 'Hace 3h' },
    { id: 'OP-2026-003', cliente: 'Navas Exports', tipo: 'Export', origen: 'Melbourne', destino: 'Algeciras', incoterm: 'FOB', modo: 'Aereo', estado: 'Seller', actualizacion: 'Hace 12h' },
    { id: 'OP-2026-004', cliente: 'Industries Garza', tipo: 'Import', origen: 'Rotterdam', destino: 'Bilbao', incoterm: 'FOB', modo: 'Maritimo', estado: 'Vessel', actualizacion: 'Hace 5m' },
    { id: 'OP-2026-005', cliente: 'Saturn Freight', tipo: 'Import', origen: 'Valencia', destino: 'Bangkok', incoterm: 'FOB', modo: 'Maritimo', estado: 'Vessel', actualizacion: 'Hace 5m' },
    { id: 'OP-2026-006', cliente: 'Costa Forwarding', tipo: 'Export', origen: 'Sevilla', destino: 'Santos', incoterm: 'CIF', modo: 'Maritimo', estado: 'Carrier', actualizacion: 'Hace 1d' },
    { id: 'OP-2026-007', cliente: 'Atlas Retail', tipo: 'Import', origen: 'Hamburgo', destino: 'Valencia', incoterm: 'EXW', modo: 'Terrestre', estado: 'Buyer', actualizacion: 'Hace 2d' },
    { id: 'OP-2026-008', cliente: 'Blue Wave Cargo', tipo: 'Export', origen: 'Bilbao', destino: 'Montreal', incoterm: 'DAP', modo: 'Maritimo', estado: 'En transito', actualizacion: 'Hace 4h' },
];

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

const obtenerOpcionesUnicas = (campo) => {
    return [...new Set(operaciones.map((operacion) => operacion[campo]))];
};

const opcionesFiltros = {
    ids: obtenerOpcionesUnicas('id'),
    clientes: obtenerOpcionesUnicas('cliente'),
    tipos: obtenerOpcionesUnicas('tipo'),
    origenes: obtenerOpcionesUnicas('origen'),
    incoterms: obtenerOpcionesUnicas('incoterm'),
    modos: obtenerOpcionesUnicas('modo'),
    estados: obtenerOpcionesUnicas('estado'),
};

const operacionesFiltradas = computed(() => {
    const texto = filtros.value.busqueda.trim().toLowerCase();

    return operaciones.filter((operacion) => {
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
            ].some((valor) => valor.toLowerCase().includes(texto));

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
            </div>
        </section>
    </main>
</template>
