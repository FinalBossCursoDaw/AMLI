<template>
    <div class="relative z-50 w-full pt-3 px-2 sm:pl-24 sm:pr-6">
        <img
            src="/imagenes/barraheader.png"
            alt="header"
            class="w-full h-auto block"
        />

        <div class="absolute inset-y-0 left-56 sm:left-72 lg:left-80 flex items-center">
            <div class="flex items-center gap-2 sm:gap-10">
                <h1 class="text-[14px] sm:text-[28px] font-montserrat font-bold text-[#303030] leading-none">
                    {{ title }}
                </h1>
                <p class="text-[10px] sm:text-[22px] font-normal text-[#a5a5a5] leading-none">
                    {{ subtitle }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        default: 'Dashboard',
    },
    subtitle: {
        type: String,
        default: '',
    },
});
</script>

<style scoped>
</style>
