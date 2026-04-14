<script setup lang="ts">
defineProps<{
    idCliente: string;
    fechaAlta: string;
    estado: string;
}>();
</script>

<template>
    <div class="mb-5 rounded-lg border border-[#ded8da] bg-white px-5 py-4 shadow-sm">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-wrap items-center gap-4 text-[11px] text-[#8b8688]">
                <div class="rounded border border-[#d8d2d4] bg-[#fbfafb] px-3 py-1.5 font-montserrat font-medium text-[#504c4d]">
                    ID: {{ idCliente }}
                </div>
                <p class="font-montserrat">Fecha de alta: {{ fechaAlta }}</p>
            </div>

            <div class="flex items-center gap-2">
                <span class="font-montserrat text-[11px] text-[#7b7778]">Estado:</span>
                <span class="rounded-full bg-[#4f815d] px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.08em] text-white">
                    {{ estado }}
                </span>
            </div>
        </div>
    </div>
</template>
