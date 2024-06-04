<template>
  <Head title="بازی تک نفره" />
  <auth-without-sidebar-layout>
    <template #content>
      <app-box class="flex flex-col gap-4 p-6">
        <h1>بازی دو نفره</h1>
        <p>کدام دسته بندی را انتخاب می کنید؟</p>
        <div class="grid grid-cols-3 gap-4">
          <button
            v-for="category in categories"
            :key="category.id"
            @click.prevent="selectedCategory(category.id)"
            class="px-0"
            :class="`btn-border text-${pickColor} border-${pickColor} hover:!bg-${pickColor}`"
          >
            {{ category.name }}
          </button>
        </div>
      </app-box>
    </template>
  </auth-without-sidebar-layout>
</template>
<script setup>
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import AppBox from "@/Components/AppBox.vue";
import { Head, router } from "@inertiajs/vue3";
import { computed, onMounted, onUnmounted } from "vue";
import {
  preventGoBack,
  preventReload,
  allowGoBack,
  allowReload,
} from "@/Composables/preventer";

onMounted(() => {
  preventGoBack();
  preventReload();
});

onUnmounted(() => {
  allowGoBack();
  allowReload();
});

const props = defineProps({
  categories: Object,
  gameId: Number,
});

const pickColor = computed(() => {
  const colors = ["green-500", "red-500", "blue-light"];
  return colors[Math.floor(Math.random() * colors.length)];
});

const selectedCategory = (categoryId) =>
  router.post(route("multi.setQuiz", props.gameId), {
    category: categoryId,
    color: pickColor.value,
  });
</script>
