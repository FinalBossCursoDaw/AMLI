<script setup lang="ts">
// Props para personalizar el botón
const props = defineProps({
  text: {
    type: String,
    default: ''
  },
  showArrow: {
    type: Boolean,
    default: true
  },
  disabled: {
    type: Boolean,
    default: false
  },
  href: {
    type: String,
    default: null
  },
  type: {
    type: String,
    default: 'button'
  }
});

const emit = defineEmits(['click']);

const handleClick = () => {
  if (!props.disabled && !props.href) {
    emit('click');
  }
};
</script>

<template>
  <!-- Si tiene href, renderiza como enlace -->
  <a
    v-if="href"
    :href="href"
    class="group relative flex w-full items-center justify-between overflow-hidden rounded-lg px-6 py-4 font-montserrat text-base font-semibold text-white transition-all hover:shadow-lg"
    :style="{
      background: 'linear-gradient(90deg, #CB0C14 56%, #65060A 100%)'
    }"
  >
    <span class="flex-1 text-center">{{ text }}</span>

    <!-- Flecha a la derecha -->
    <svg
      v-if="showArrow"
      xmlns="http://www.w3.org/2000/svg"
      class="h-5 w-5 transition-transform group-hover:translate-x-1"
      viewBox="0 0 20 20"
      fill="currentColor"
    >
      <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
    </svg>
  </a>

  <!-- Si no tiene href, renderiza como botón -->
  <button
    v-else
    @click="handleClick"
    :type="type"
    :disabled="disabled"
    class="group relative flex w-full items-center justify-between overflow-hidden rounded-lg px-6 py-4 font-montserrat text-base font-semibold text-white transition-all hover:shadow-lg disabled:cursor-not-allowed disabled:opacity-50"
    :style="{
      background: 'linear-gradient(90deg, #CB0C14 56%, #65060A 100%)'
    }"
  >
    <span class="flex-1 text-center">{{ text }}</span>

    <!-- Flecha a la derecha -->
    <svg
      v-if="showArrow"
      xmlns="http://www.w3.org/2000/svg"
      class="h-5 w-5 transition-transform group-hover:translate-x-1"
      viewBox="0 0 20 20"
      fill="currentColor"
    >
      <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
    </svg>
  </button>
</template>
