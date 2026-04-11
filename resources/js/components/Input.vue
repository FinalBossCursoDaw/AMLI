<script setup lang="ts">
// Props para personalizar el input
const props = defineProps({
  placeholder: {
    type: String,
    default: 'Introduce el texto'
  },
  type: {
    type: String,
    default: 'text'
  },
  modelValue: {
    type: String,
    default: ''
  },
  icon: {
    type: String,
    default: ''
  }
});

const emit = defineEmits(['update:modelValue']);

const handleInput = (event: Event) => {
  const target = event.target as HTMLInputElement;
  emit('update:modelValue', target.value);
};
</script>

<template>
  <div class="relative w-full">
    <div class="relative">
      <!-- Ícono (opcional) -->
      <div v-if="icon" class="absolute left-4 top-1/2 -translate-y-1/2 text-[#AAABAA]">
        <svg v-if="icon === 'email'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
          <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
        </svg>
        <svg v-else-if="icon === 'lock'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
        </svg>
        <svg v-else-if="icon === 'user'" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
        </svg>
      </div>

      <!-- Input -->
      <input
        :type="type"
        :value="modelValue"
        @input="handleInput"
        :placeholder="placeholder"
        :class="[
          'w-full rounded-lg border border-[#E0E0E0] bg-white px-4 py-3 font-montserrat text-sm text-[#2F2E30] placeholder:text-[#AAABAA] focus:border-[#cb0c14] focus:outline-none focus:ring-1 focus:ring-[#cb0c14] transition-colors',
          icon ? 'pl-12' : ''
        ]"
      />
    </div>
  </div>
</template>
