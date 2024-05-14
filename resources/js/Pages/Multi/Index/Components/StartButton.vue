<template>
  <div class="flex flex-col items-center justify-center px-2 md:px-0 py-2">
    <div
      class="bg-blue-light px-2 md:px-4 py-2 rounded-md text-center text-white"
      :class="{ 'hover:cursor-pointer': text == 'user' }"
      @click="start(text)"
    >
      {{ buttonText }}
    </div>
  </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { computed } from "vue";
const props = defineProps({
  text: String,
  game: Object,
});

const buttonText = props.text == "user" ? "نوبت شما" : "نوبت حریف";

const pickColor = computed(() => {
  const colors = ["green-500", "red-500", "blue-light"];
  return colors[Math.floor(Math.random() * colors.length)];
});

const start = (text) => {
  if (text == "user") {
    // If category has not set
    if (props.game.category_id == 6) {
      return router.post(route("multi-player.category", props.game.id));
    }

    // Else
    return router.put(route("multi-player.quiz", props.game.id), {
      color: pickColor.value,
    });
  }
};
</script>
