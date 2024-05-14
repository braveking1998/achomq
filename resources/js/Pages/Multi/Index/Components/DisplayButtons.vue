<template>
  <div
    class="flex gap-2 p-2 border-b-2 border-gray-700 justify-center items-center flex-wrap"
  >
    <div
      v-for="answer in answers"
      class="w-10 h-10 rounded-md text-center leading-10 text-white text-sm"
      :class="[answer.is_correct == true ? 'bg-green-500' : 'bg-red-500']"
    >
      {{ answer.is_correct == true ? "درست" : "غلط" }}
    </div>
  </div>
</template>

<script setup>
defineProps({
  answers: Array,
});
</script>
