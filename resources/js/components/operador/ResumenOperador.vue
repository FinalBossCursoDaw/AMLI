<script setup>
import { ArrowUpTrayIcon } from '@heroicons/vue/24/outline';
</script>

<template>
    <div class="mb-6 flex justify-end">
        <button
            type="button"
            class="inline-flex items-center gap-2 rounded-lg border border-[#d7d0d2] bg-white px-4 py-3 font-montserrat text-[12px] font-semibold text-[#4f4a4b] shadow-[0_10px_22px_rgba(48,48,48,0.08)] transition hover:-translate-y-0.5 hover:border-[#c9171d] hover:text-[#c9171d] hover:shadow-[0_14px_28px_rgba(48,48,48,0.12)]"
        >
            <ArrowUpTrayIcon class="h-4 w-4 text-[#5f5a5b]" />
            Subir archivo
        </button>
    </div>
</template>
