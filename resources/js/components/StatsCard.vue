<template>
    <div class="bg-white rounded-lg shadow-md p-3 flex items-center gap-2 w-56">
        <div class="w-12 h-12">
            <img 
                v-if="props.iconoType === 'image'"
                :src="props.icono"
                :alt="props.label"
                class="w-full h-full object-contain"
            />
            <div 
                v-else
                class="text-4xl flex items-center justify-center"
            >
                {{ props.icono }}
            </div>
        </div>
        <div>
            <p class="text-4xl font-bold text-[#303030]">
                {{ numero }}
            </p>
            <p class="text-lg text-[#666] font-medium">
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
