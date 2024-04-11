<template>
  <div>
    <div class="flex justify-center gap-8 items-center md:hidden flex-wrap">
      <button
        @click="isOpen = !isOpen"
        class="p-2 border rounded border-gray-700"
      >
        <font-awesome-icon :icon="['fas', 'bars']" size="2xl" />
      </button>
      <div class="flex flex-col justify-center items-center gap-4">
        <div class="w-24 h-24 border-2 border-gray-700 p-1 rounded-full">
          <img :src="src" alt="profile" class="w-full h-full rounded-full" />
        </div>
        <div class="text-xl font-bold">{{ name }}</div>
      </div>
    </div>
    <slot name="header" />
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
  src: String,
  name: String,
});

const isOpen = ref(false);
</script>
