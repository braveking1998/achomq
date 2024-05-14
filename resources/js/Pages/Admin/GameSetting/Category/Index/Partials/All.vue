<template>
  <!-- All Categories -->
  <box-with-title>
    <!-- Title -->
    <template #title>دسته بندی ها</template>
    <!-- Loop Category -->
    <div
      class="grid grid-cols-12 items-center text-lg"
      v-for="category in categories"
      :key="category.id"
    >
      <div class="col-span-3">{{ category.name }}</div>
      <div class="col-span-3">{{ category.slug }}</div>
      <div class="col-span-3">تعداد سوالات: {{ category.questions_count }}</div>
      <div class="col-span-3 flex flex-row gap-4">
        <Link
          :href="route('admin.setting.category.edit', category.id)"
          class="btn-primary"
          v-show="category.slug !== 'default'"
        >
          ✍🏻
        </Link>
        <Link
          :href="route('admin.setting.category.destroy', category.id)"
          method="delete"
          as="button"
          class="btn-primary"
          v-show="category.slug !== 'default'"
        >
          🗑️
        </Link>
      </div>
    </div>
  </box-with-title>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import BoxWithTitle from "@/Components/BoxWithTitle.vue";

defineProps({
  categories: Object,
});
</script>
