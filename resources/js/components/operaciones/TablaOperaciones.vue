<script setup>
import { ArrowLongRightIcon, ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/outline';
import { computed } from 'vue';

const props = defineProps({
    operaciones: {
        type: Array,
        required: true,
    },
    paginaActual: {
        type: Number,
        required: true,
    },
    totalPaginas: {
        type: Number,
        required: true,
    },
    totalRegistros: {
        type: Number,
        required: true,
    },
    porPagina: {
        type: Number,
        required: true,
    },
});

const emit = defineEmits(['cambiar-pagina']);

const obtenerClaseEstado = (estado) => {
    const clases = {
        Carrier: 'bg-[#f1eff0] text-[#676163]',
        Buyer: 'bg-[#ede8ea] text-[#7a7276]',
        Seller: 'bg-[#ebe7e8] text-[#726c70]',
        Vessel: 'bg-[#ece8e9] text-[#666064]',
        'En transito': 'bg-[#efe7da] text-[#8b6632]',
    };

    return clases[estado] || 'bg-[#f1eff0] text-[#676163]';
};

const inicio = computed(() => {
    if (props.totalRegistros === 0) {
        return 0;
    }

    return (props.paginaActual - 1) * props.porPagina + 1;
});

const fin = computed(() => {
    return Math.min(props.paginaActual * props.porPagina, props.totalRegistros);
});

const paginas = computed(() => {
    return Array.from({ length: props.totalPaginas }, (_, index) => {
        return index + 1;
    });
});
</script>

<template>
    <section class="amli-panel">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1120px]">
                <thead class="amli-table-head">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">ID</th>
                        <th class="px-4 py-3 text-left font-semibold">Cliente</th>
                        <th class="px-4 py-3 text-left font-semibold">Tipo</th>
                        <th class="px-4 py-3 text-left font-semibold">Origen</th>
                        <th class="px-4 py-3 text-left font-semibold">Destino</th>
                        <th class="px-4 py-3 text-left font-semibold">Incoterm</th>
                        <th class="px-4 py-3 text-left font-semibold">Modo</th>
                        <th class="px-4 py-3 text-left font-semibold">Estado actual</th>
                        <th class="px-4 py-3 text-left font-semibold">Ultima actualizacion</th>
                        <th class="px-4 py-3 text-right font-semibold">Accion</th>
                    </tr>
                </thead>

                <tbody v-if="operaciones.length > 0">
                    <tr
                        v-for="operacion in operaciones"
                        :key="operacion.id"
                        class="amli-table-row"
                    >
                        <td class="px-4 py-4 font-semibold text-[#353233]">{{ operacion.id }}</td>
                        <td class="px-4 py-4">{{ operacion.cliente }}</td>
                        <td class="px-4 py-4">{{ operacion.tipo }}</td>
                        <td class="whitespace-nowrap px-4 py-4">{{ operacion.origen }}</td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2 whitespace-nowrap text-[#6c6769]">
                                <ArrowLongRightIcon class="h-4 w-4 text-[#d0c8cb]" />
                                <span>{{ operacion.destino }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">{{ operacion.incoterm }}</td>
                        <td class="px-4 py-4">{{ operacion.modo }}</td>
                        <td class="px-4 py-4">
                            <span :class="['inline-flex rounded-full px-3 py-1 text-[10px] font-semibold leading-none', obtenerClaseEstado(operacion.estado)]">
                                {{ operacion.estado }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-[#686163]">{{ operacion.actualizacion }}</td>
                        <td class="px-4 py-4 text-right">
                            <a
                                :href="`/operaciones/${operacion.id}/tracking`"
                                class="inline-flex rounded-md border border-[#e6dedf] bg-[#f8f4f5] px-4 py-2 text-[12px] font-semibold text-[#4f4a4b] transition hover:border-[#c9171d] hover:bg-[#c9171d] hover:text-white"                            >
                                Ver tracking
                            </a>
                        </td>
                    </tr>
                </tbody>

                <tbody v-else>
                    <tr class="border-t border-[#eee8ea]">
                        <td colspan="10" class="px-4 py-8 text-center font-montserrat text-[13px] text-[#7a7476]">
                            No hay operaciones que coincidan con los filtros.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex flex-col gap-3 border-t border-[#eee8ea] bg-[#fffdfd] px-4 py-3 font-montserrat text-[11px] text-[#8e8588] sm:flex-row sm:items-center sm:justify-between">
            <p>Mostrando {{ inicio }} - {{ fin }} de {{ totalRegistros }} operaciones</p>

            <div class="flex items-center justify-end gap-1 text-[#4f4a4b]">
                <button
                    type="button"
                    class="rounded p-1 hover:bg-[#f3eff0] disabled:cursor-not-allowed disabled:opacity-40"
                    :disabled="paginaActual === 1"
                    @click="emit('cambiar-pagina', paginaActual - 1)"
                >
                    <ChevronLeftIcon class="h-4 w-4" />
                </button>

                <button
                    v-for="pagina in paginas"
                    :key="pagina"
                    type="button"
                    :class="[
                        'rounded border px-2 py-0.5',
                        pagina === paginaActual ? 'border-[#dad3d5] bg-[#f8f6f7]' : 'border-[#dad3d5] hover:bg-[#f8f6f7]'
                    ]"
                    @click="emit('cambiar-pagina', pagina)"
                >
                    {{ pagina }}
                </button>

                <button
                    type="button"
                    class="rounded p-1 hover:bg-[#f3eff0] disabled:cursor-not-allowed disabled:opacity-40"
                    :disabled="paginaActual === totalPaginas || totalPaginas === 0"
                    @click="emit('cambiar-pagina', paginaActual + 1)"
                >
                    <ChevronRightIcon class="h-4 w-4" />
                </button>
            </div>
        </div>
    </section>
</template>
