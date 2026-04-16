<script setup>
import { ArrowUpTrayIcon } from '@heroicons/vue/24/outline';
</script>

<template>
    <div class="mb-5 flex justify-end">
        <button
            type="button"
            class="inline-flex items-center gap-2 rounded-lg border border-[#ddd7d9] bg-white px-4 py-3 font-montserrat text-[12px] font-medium text-[#5f5a5b] shadow-sm transition hover:bg-[#faf8f9]"
        >
            <ArrowUpTrayIcon class="h-4 w-4 text-[#5f5a5b]" />
            Subir archivo
        </button>
    </div>
</template>
