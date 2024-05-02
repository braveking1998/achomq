<template>
  <Head title="پروفایل" />

  <AuthWithoutSidebarLayout>
    <template #header>
      <Breadcrumbs :breadcrumbs="breadcrumbs" />
    </template>

    <template #content>
      <Box class="p-6">
        <ProfileImages :images="images" />
      </Box>
    </template>
  </AuthWithoutSidebarLayout>
</template>

<script setup>
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import Box from "@/Components/Box.vue";
import ProfileImages from "@/Pages/Profile/Index/Partials/ProfileImages.vue";
import { Head, usePage } from "@inertiajs/vue3";

defineProps({
  images: Object,
});

const page = usePage();

// breadcrumbs
const breadcrumbs = [
  { label: "داشبورد", url: route("dashboard") },
  { label: "پروفایل", url: route("profile.index") },
];
</script>
