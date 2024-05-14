<template>
  <Head title="ادمین" />
  <auth-without-sidebar-layout>
    <template #content>
      <div class="flex flex-col flex-wrap sm:flex-row gap-8 items-center">
        <div>
          <Link :href="route('admin.questions.index')" class="btn-primary"
            >مدیریت سوالات</Link
          >
        </div>
        <div>
          <Link :href="route('admin.setting.index')" class="btn-danger"
            >تنظیمات بازی ها</Link
          >
        </div>
        <div>
          <Link
            :href="route('admin.notification.index')"
            class="btn-success w-full"
            >ارسال پیام به کاربران</Link
          >
        </div>
      </div>
    </template>
  </auth-without-sidebar-layout>
</template>

<script setup>
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
  question: Number,
});
</script>
