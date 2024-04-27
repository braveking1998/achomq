<template>
  <Head title="ادمین" />
  <AuthWithoutSidebarLayout>
    <template #content>
      <div class="grid grid-cols-3 gap-8">
        <div v-if="question">
          <Link
            :href="route('admin.submit.edit', question.id)"
            class="btn-dashboard w-full h-full block leading-5"
            >تایید سوالات</Link
          >
        </div>
        <Link
          :href="route('admin.setting.index')"
          class="btn-dashboard text-red-500 border-red-500 hover:bg-red-500"
          >تنظیمات بازی ها</Link
        >
        <Link :href="route('admin.notification.index')" class="btn-dashboard"
          >ارسال پیام به کاربران</Link
        >
      </div>
    </template>
  </AuthWithoutSidebarLayout>
</template>

<script setup>
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
  question: Object,
});
</script>
