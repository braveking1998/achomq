<template>
  <Head title="مشاهده سوال" />
  <auth-without-sidebar-layout>
    <template #header>
      <app-breadcrumbs :breadcrumbs="breadcrumbs">
        <template #right-side>
          <div class="flex gap-4">
            <Link
              :href="route('admin.questions.edit', question.id)"
              class="btn-primary bg-green-500"
              >ویرایش سوال</Link
            >
          </div>
        </template>
      </app-breadcrumbs>
    </template>

    <template #content>
      <app-box class="flex flex-col gap-4 p-6">
        <p class="text-gray-500"><span>متن سوال: </span>{{ question.text }}</p>
        <p class="text-gray-500">
          <span>دسته بندی: </span>{{ question.category.name }}
        </p>
        <p class="text-gray-500"><span>سطح: </span>{{ question.level.name }}</p>
        <p class="text-gray-500">
          <span>وضعیت سوال: </span>{{ useQuestionStatus(question).value }}
        </p>
        <p class="text-gray-500">
          <span>تاریخ ایجاد: </span>{{ formatedDate }}
        </p>
        <ul class="flex flex-col gap-4">
          <li
            v-for="(answer, index) in question.answers"
            :key="answer.id"
            class="text-gray-500"
          >
            <span>پاسخ {{ index + 1 }}: </span>{{ answer.text }}
            <span v-if="answer.is_correct" class="pr-4">✔️</span>
          </li>
        </ul>
      </app-box>
    </template>
  </auth-without-sidebar-layout>
</template>

<script setup>
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import AppBreadcrumbs from "@/Components/AppBreadcrumbs.vue";
import AppBox from "@/Components/AppBox.vue";
import { Head, Link } from "@inertiajs/vue3";
import { useFormattedShamsiDate } from "@/Composables/date.js";
import { useQuestionStatus } from "@/Composables/questionStatus.js";

const props = defineProps({
  question: Object,
  prevUrl: String,
});

const breadcrumbs = [
  { label: "مدیریت", url: route("admin.index") },
  { label: "سوالات", url: props.prevUrl },
];

// Date
const { formatedDate } = useFormattedShamsiDate(props.question.created_at);
</script>
