<template>
  <div
    class="flex flex-col justify-center items-center gap-4 border-b-2 border-gray-700 p-5"
  >
    <!-- Profile image -->
    <div class="w-24 h-24 border-2 border-gray-700 p-1 rounded-full">
      <img :src="src" alt="profile" class="w-full h-full rounded-full" />
    </div>
    <!-- User's name -->
    <div class="w-full text-center">{{ name }}</div>
  </div>
</template>

<script setup>
defineProps({
  src: String,
  name: String,
});
</script>
