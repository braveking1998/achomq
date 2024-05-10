<template>
  <Head title="مشاهده پیام" />

  <AuthWithoutSidebarLayout>
    <template #header>
      <Breadcrumbs :breadcrumbs="breadcrumbs"> </Breadcrumbs>
    </template>

    <template #content>
      <Box class="flex flex-col gap-4 p-6">
        <p class="text-gray-500">
          <span>عنوان پیام: </span
          ><span class="font-bold">{{ message.data.title }}</span>
        </p>
        <div>
          <p class="text-gray-500">متن پیام:</p>
          <p class="text-gray-500 mt-4">{{ message.data.text }}</p>
        </div>

        <div
          class="flex flex-col items-center justify-center sm:flex-row gap-2 sm:gap-4 mt-4 sm:mt-0"
        >
          <Link class="btn-primary px-4 py-2" :href="route('messages.index')"
            >بازگشت به عقب</Link
          >
          <Link
            class="btn-danger px-4 py-2"
            :href="route('messages.destroy', message.id)"
            method="DELETE"
            as="button"
            >حذف پیام</Link
          >
        </div>
      </Box>
    </template>
  </AuthWithoutSidebarLayout>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import Box from "@/Components/Box.vue";

const props = defineProps({
  message: Object,
});

// breadcrumbs
const breadcrumbs = [
  { label: "داشبورد", url: route("dashboard") },
  { label: "همه پیام ها", url: route("messages.index") },
];
</script>
