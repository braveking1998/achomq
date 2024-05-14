<template>
  <Head title="پروفایل" />

  <auth-without-sidebar-layout>
    <template #header>
      <app-breadcrumbs :breadcrumbs="breadcrumbs" />
    </template>

    <template #content>
      <app-box class="p-6">
        <profile-images :images="images" />
      </app-box>
    </template>
  </auth-without-sidebar-layout>
</template>

<script setup>
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import AppBreadcrumbs from "@/Components/AppBreadcrumbs.vue";
import AppBox from "@/Components/AppBox.vue";
import ProfileImages from "@/Pages/Profile/Index/Components/ProfileImages.vue";
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
