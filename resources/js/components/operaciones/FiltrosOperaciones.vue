<script setup>
import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    filtros: {
        type: Object,
        required: true,
    },
    opciones: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['update:filtros']);

const actualizarFiltro = (campo, valor) => {
    emit('update:filtros', {
        ...props.filtros,
        [campo]: valor,
    });
};

const configuracionFiltros = [
    { id: 'id', etiqueta: 'ID', opciones: 'ids' },
    { id: 'cliente', etiqueta: 'Cliente', opciones: 'clientes' },
    { id: 'tipo', etiqueta: 'Tipo', opciones: 'tipos' },
    { id: 'origen', etiqueta: 'Origen', opciones: 'origenes' },
    { id: 'incoterm', etiqueta: 'Incoterm', opciones: 'incoterms' },
    { id: 'modo', etiqueta: 'Modo', opciones: 'modos' },
    { id: 'estado', etiqueta: 'Estado', opciones: 'estados' },
];
</script>

<template>
    <section class="rounded-xl border border-[#ddd6d8] bg-white px-5 py-4 shadow-[0_2px_10px_rgba(0,0,0,0.08)]">
        <div class="flex flex-col gap-3 xl:flex-row xl:flex-wrap xl:items-center">
            <select
                v-for="filtro in configuracionFiltros"
                :key="filtro.id"
                :value="filtros[filtro.id]"
                class="h-10 rounded-md border border-[#ebe6e8] bg-[#f6f4f5] px-3 font-montserrat text-[13px] text-[#4e4a4b] outline-none transition focus:border-[#cfb8bb]"
                @change="actualizarFiltro(filtro.id, $event.target.value)"
            >
                <option value="">{{ filtro.etiqueta }}</option>
                <option
                    v-for="opcion in opciones[filtro.opciones]"
                    :key="opcion"
                    :value="opcion"
                >
                    {{ opcion }}
                </option>
            </select>

            <div class="flex h-10 min-w-[220px] items-center gap-2 rounded-md border border-[#ebe6e8] bg-[#f6f4f5] px-3 xl:flex-1">
                <MagnifyingGlassIcon class="h-4 w-4 text-[#222222]" />
                <input
                    :value="filtros.busqueda"
                    type="text"
                    placeholder="Buscar"
                    class="w-full bg-transparent font-montserrat text-[13px] text-[#4e4a4b] outline-none placeholder:text-[#4e4a4b]"
                    @input="actualizarFiltro('busqueda', $event.target.value)"
                />
            </div>
        </div>
    </section>
</template>
