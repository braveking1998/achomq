<template>
  <div>
    <!-- Bar icon -->
    <div class="flex justify-center gap-8 items-center md:hidden flex-wrap">
      <button
        @click="isOpen = !isOpen"
        class="p-2 border rounded border-gray-700"
      >
        <font-awesome-icon :icon="['fas', 'bars']" size="2xl" />
      </button>
      <div class="text-xl font-bold">{{ title }}</div>
      <slot name="header" />
    </div>

    <!-- Toggled menu -->
    <nav
      :class="[isOpen ? 'flex' : 'hidden md:flex']"
      class="flex-col md:flex-row mt-4 px-8 md:mt-0 md:px-0 md:flex md:gap-8"
    >
      <slot />
    </nav>
  </div>
</template>
<script setup>
import { ref } from "vue";

defineProps({
  title: String,
});

const isOpen = ref(false);
</script>
