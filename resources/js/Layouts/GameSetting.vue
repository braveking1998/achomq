<template>
  <AuthWithoutSidebarLayout>
    <template #header>
      <Breadcrumbs :breadcrumbs="breadcrumbs" />
    </template>
    <template #content>
      <Box class="p-6">
        <div class="flex flex-col md:flex-row gap-4 md:px-0">
          <Link
            class="btn-bordered"
            :href="route('admin.setting.category.index')"
            :class="{ 'btn-primary': tab === 'category' }"
          >
            دسته بندی
          </Link>
          <Link
            class="btn-bordered"
            :href="route('admin.setting.level.index')"
            :class="{ 'btn-primary': tab === 'level' }"
          >
            سطح
          </Link>
          <Link
            class="btn-bordered"
            :href="route('admin.setting.stats')"
            :class="{ 'btn-primary': tab === 'stats' }"
          >
            آمار
          </Link>
          <Link
            class="btn-bordered"
            :href="route('admin.setting.images.index')"
            :class="{ 'btn-primary': tab === 'images' }"
          >
            آپلود تصاویر عمومی
          </Link>
        </div>
      </Box>
      <Box class="p-6 mt-8">
        <div class="flex flex-col gap-8 md:px-0">
          <slot>Default</slot>
        </div>
      </Box>
    </template>
  </AuthWithoutSidebarLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import Box from "@/Components/Box.vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";

defineProps({
  tab: String,
});

// breadcrumbs
const breadcrumbs = [{ label: "پنل ادمین", url: route("admin.index") }];
</script>
