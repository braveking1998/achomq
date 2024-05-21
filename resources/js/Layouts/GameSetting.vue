<template>
  <auth-without-sidebar-layout>
    <template #header>
      <app-breadcrumbs :breadcrumbs="breadcrumbs" />
    </template>
    <template #content>
      <app-box class="p-6">
        <div class="flex flex-col md:flex-row gap-4 md:px-0">
          <Link
            class="btn-primary-border"
            :href="route('admin.setting.category.index')"
            :class="{ 'btn-primary text-white': tab === 'category' }"
          >
            دسته بندی
          </Link>
          <Link
            class="btn-primary-border"
            :href="route('admin.setting.level.index')"
            :class="{ 'btn-primary text-white': tab === 'level' }"
          >
            سطح
          </Link>
          <Link
            class="btn-primary-border"
            :href="route('admin.setting.stats')"
            :class="{ 'btn-primary text-white': tab === 'stats' }"
          >
            آمار
          </Link>
          <Link
            class="btn-primary-border"
            :href="route('admin.setting.images.index')"
            :class="{ 'btn-primary text-white': tab === 'images' }"
          >
            آپلود تصاویر عمومی
          </Link>
        </div>
      </app-box>
      <app-box class="p-6 mt-8">
        <div class="flex flex-col gap-8 md:px-0">
          <slot>Default</slot>
        </div>
      </app-box>
    </template>
  </auth-without-sidebar-layout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import AppBox from "@/Components/AppBox.vue";
import AppBreadcrumbs from "@/Components/AppBreadcrumbs.vue";

defineProps({
  tab: String,
});

// breadcrumbs
const breadcrumbs = [{ label: "مدیریت", url: route("admin.index") }];
</script>
