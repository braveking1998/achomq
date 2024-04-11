<template>
  <div
    class="flex md:flex-col md:gap-4 items-center justify-around md:justify-center mt-4 md:mt-0 flex-wrap"
  >
    <div class="bg-gray-200 flex items-center relative">
      <div class="bg-gray-400 px-3 pt-1">
        <Link
          :href="route('dashboard')"
          class="text-3xl font-bold text-gray-700"
          >+</Link
        >
      </div>
      <div class="px-6">
        {{ coins }}
      </div>
      <div class="text-4xl absolute left-0 ml-[-27px] top-1">🌕</div>
    </div>
    <div class="bg-gray-200 flex items-center relative">
      <div class="bg-gray-400 px-3 pt-1">
        <Link
          :href="route('dashboard')"
          class="text-3xl font-bold text-gray-700"
          >+</Link
        >
      </div>
      <div class="px-6">
        {{ gems }}
      </div>
      <div class="text-4xl absolute left-0 ml-[-27px] top-1">💎</div>
    </div>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  coins: Number,
  gems: Number,
});
</script>
