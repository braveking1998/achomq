<template>
  <Head title="بازی تک نفره" />
  <auth-without-sidebar-layout>
    <template #header v-if="canPlay === 'false'">
      <app-breadcrumbs :breadcrumbs="breadcrumbs"> </app-breadcrumbs>
    </template>

    <template #content>
      <app-box class="flex flex-col gap-4 p-6" v-if="canPlay === 'true'">
        <h1>بازی تک نفره</h1>
        <p>کدام دسته بندی را انتخاب می کنید؟</p>
        <div class="grid grid-cols-3 gap-4">
          <button
            v-for="category in categories"
            :key="category.id"
            @click.prevent="selectedCategory(category.id)"
            class="px-0"
            :class="`btn-dashboard text-${pickColor} border-${pickColor} hover:bg-${pickColor}`"
          >
            {{ category.name }}
          </button>
        </div>
      </app-box>
      <app-box class="flex flex-col gap-4 p-6" v-else>
        <h1>شما تعداد قلب های کافی برای بازی ندارید.</h1>
      </app-box>
    </template>
  </auth-without-sidebar-layout>
</template>
<script setup>
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import AppBox from "@/Components/AppBox.vue";
import AppBreadcrumbs from "@/Components/AppBreadcrumbs.vue";
import { Head, router } from "@inertiajs/vue3";
import { computed } from "vue";

defineProps({
  categories: Object,
  canPlay: String,
});

// breadcrumbs
const breadcrumbs = [{ label: "داشبورد", url: route("dashboard") }];

const pickColor = computed(() => {
  const colors = ["green-500", "red-500", "blue-light"];
  return colors[Math.floor(Math.random() * colors.length)];
});

const selectedCategory = (categoryId) =>
  router.post("", {
    category: categoryId,
    color: pickColor.value,
  });
</script>
