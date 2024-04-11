<template>
  <box-with-title>
    <!-- Title -->
    <template #title> تنظیمات سطح ها</template>
    <!-- Level Loop -->
    <div
      class="grid grid-cols-12 items-center text-lg"
      v-for="level in levels"
      :key="level.id"
    >
      <!-- Level name -->
      <div class="col-span-3">{{ level.name }}</div>
      <!-- Level slug -->
      <div class="col-span-3">{{ level.slug }}</div>
      <!-- Level question count -->
      <div class="col-span-3">تعداد سوالات: {{ level.questions_count }}</div>
      <!-- Level links -->
      <div class="col-span-3 flex flex-row gap-4">
        <!-- Edit link -->
        <Link
          :href="route('admin.setting.level.edit', level.id)"
          class="btn-primary"
        >
          ✍🏻
        </Link>
      </div>
    </div>
  </box-with-title>
</template>

<script setup>
import BoxWithTitle from "@/Components/BoxWithTitle.vue";
import { Link } from "@inertiajs/vue3";

defineProps({
  levels: Object,
});
</script>
