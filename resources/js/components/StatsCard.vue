<template>
    <div class="group flex w-56 items-center gap-3 rounded-lg border border-[#ded7d9] bg-white p-4 shadow-[0_12px_26px_rgba(48,48,48,0.08)] transition hover:-translate-y-0.5 hover:shadow-[0_16px_32px_rgba(48,48,48,0.12)]">
        <div class="flex h-12 w-12 flex-none items-center justify-center rounded-lg bg-[#fff3f3] transition group-hover:bg-[#ffe7e7]">
            <img 
                v-if="props.iconoType === 'image'"
                :src="props.icono"
                :alt="props.label"
                class="h-8 w-8 object-contain"
            />
            <div 
                v-else
                class="flex items-center justify-center text-3xl"
            >
                {{ props.icono }}
            </div>
        </div>
        <div>
            <p class="font-montserrat text-4xl font-bold leading-none text-[#303030]">
                {{ numero }}
            </p>
            <p class="mt-1 font-montserrat text-[14px] font-semibold text-[#696365]">
                {{ props.label }}
            </p>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    icono: {
        type: String,
        required: true,
    },
    iconoType: {
        type: String,
        default: 'emoji',
    },
    label: {
        type: String,
        required: true,
    },
    apiUrl: {
        type: String,
        required: true,
    },
});

const numero = ref(0);

onMounted(async () => {
    try {
        const response = await axios.get(props.apiUrl);
        numero.value = response.data.total;
    } catch (error) {
        console.error('Error:', error);
        numero.value = 0;
    }
});

</script>

<style scoped>
</style>
