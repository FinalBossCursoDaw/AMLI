<template>
    <div class="pointer-events-none relative z-50 w-full px-2 pt-3 sm:pl-24 sm:pr-6">
        <img
            src="/imagenes/barraheader.png"
            alt="header"
            class="block h-auto w-full drop-shadow-[0_10px_22px_rgba(48,48,48,0.18)]"
        />

        <div class="absolute inset-y-0 left-72 flex items-center sm:left-[24rem] lg:left-[27rem]">
            <div class="flex items-center gap-2 sm:gap-10">
                <h1 class="font-montserrat text-[14px] font-bold leading-none text-[#303030] sm:text-[28px]">
                    {{ title }}
                </h1>
                <p class="text-[10px] font-normal leading-none text-[#8d8789] sm:text-[22px]">
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
