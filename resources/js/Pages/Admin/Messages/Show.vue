<template>
  <Head title="مشاهده پیام" />

  <AuthWithoutSidebarLayout>
    <template #header>
      <app-breadcrumbs :breadcrumbs="breadcrumbs">
        <template #right-side>
          <div class="flex gap-4">
            <Link
              :href="route('admin.messages.destroy', message.id)"
              class="btn-primary bg-red-500"
              method="delete"
              as="button"
              >حذف پیام</Link
            >
          </div>
        </template>
      </app-breadcrumbs>
    </template>

    <template #content>
      <app-box class="flex flex-col gap-4 p-6">
        <p class="text-gray-500">
          <span>عنوان پیام: </span>{{ message.title }}
        </p>
        <p class="text-gray-500"><span>متن پیام: </span>{{ message.text }}</p>
        <div>
          <h2 class="text-gray-500 font-bold">کاربران دریافت کننده</h2>
          <div v-if="users === 'all'" class="text-gray-500 mt-4">
            همه کاربران
          </div>
          <div class="mt-4" v-else>
            <span
              class="text-gray-500"
              v-for="(user, index) in users"
              :key="user.id"
              >{{ user.name }}<span v-if="index + 1 < users.length">, </span>
            </span>
          </div>
        </div>
      </app-box>
    </template>
  </AuthWithoutSidebarLayout>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import AppBreadcrumbs from "@/Components/AppBreadcrumbs.vue";
import AppBox from "@/Components/AppBox.vue";

const props = defineProps({
  message: Object,
  users: [Object, String],
});

// breadcrumbs
const breadcrumbs = [
  { label: "مدیریت", url: route("admin.index") },
  { label: "همه پیام ها", url: route("admin.messages.index") },
];
</script>
