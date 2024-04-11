<template>
  <Head title="دسته بندی ها" />

  <game-setting tab="category">
    <category-all :categories="categories" />
    <category-create />
  </game-setting>
</template>
<script setup>
import { Head } from "@inertiajs/vue3";
import GameSetting from "@/Layouts/GameSetting.vue";
import CategoryCreate from "@/Pages/Admin/GameSetting/Category/Index/Partials/Create.vue";
import CategoryAll from "@/Pages/Admin/GameSetting/Category/Index/Partials/All.vue";

defineProps({
  categories: Object,
});
</script>
