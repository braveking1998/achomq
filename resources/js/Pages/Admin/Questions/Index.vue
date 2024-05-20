<template>
  <Head title="همه سوالات" />
  <auth-without-sidebar-layout>
    <template #header>
      <app-breadcrumbs :breadcrumbs="breadcrumbs">
        <template #right-side>
          <div class="flex gap-2">
            <Link
              v-if="next"
              :href="route('admin.questions.submit.edit', next.id)"
              class="btn-success hidden xs:block"
              >تایید سوالات</Link
            >
          </div>
        </template>
      </app-breadcrumbs>
    </template>
    <template #content>
      <!-- Flash messages -->
      <flash-message ref="flashMessageComponent" />

      <app-search
        :categories="categories"
        :levels="levels"
        :filters="filters"
      />
      <app-box class="p-6">
        <table
          class="w-full table-auto border border-gray-500 border-collapse text-base font-medium text-gray-500"
        >
          <thead>
            <tr>
              <th class="border border-gray-500 p-2 md:p-4">ردیف</th>
              <th class="border border-gray-500">متن سوال</th>
              <th class="border border-gray-500">طراح سوال</th>
              <th class="border border-gray-500">دسته بندی</th>
              <th class="border border-gray-500">وضعیت</th>
              <th class="border border-gray-500">عملیات</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(question, index) in questions.data"
              :key="question.id"
              :class="{ 'opacity-40': question.deleted_at }"
            >
              <td class="border border-gray-500 md:p-2 text-center">
                {{ questions.from + index }}
              </td>
              <td class="border border-gray-500 md:pr-4">
                {{ question.text }}
              </td>
              <td class="border border-gray-500 text-center">
                {{ question.user.name }}
              </td>
              <td class="border border-gray-500 text-center">
                <Link
                  class="text-indigo-800 underline italic"
                  :href="
                    route('admin.questions.index', {
                      category: question.category.id,
                    })
                  "
                >
                  {{ question.category.name }}
                </Link>
              </td>
              <td class="border border-gray-500 text-center">
                {{ useQuestionStatus(question).value }}
              </td>
              <td class="border border-gray-500">
                <div
                  class="flex flex-col md:flex-row gap-2 my-2 md:m-2 items-center justify-center"
                >
                  <Link
                    :href="route('admin.questions.show', question.id)"
                    class="btn-primary text-center px-2 md:px-4"
                    >نمایش</Link
                  >
                  <Link
                    :href="route('admin.questions.edit', question.id)"
                    class="btn-primary text-center bg-green-500 px-2 md:px-4"
                    >ویرایش</Link
                  >
                  <button
                    @click="deleteQuestion(question.id)"
                    class="btn-primary text-center bg-red-500 px-2 md:px-4"
                  >
                    {{ question.deleted_at !== null ? "حذف دائمی" : "حذف" }}
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div
          v-if="questions.data.length"
          class="w-full flex justify-center my-8"
        >
          <app-pagination :links="questions.links" />
        </div>
      </app-box>
    </template>
  </auth-without-sidebar-layout>
</template>

<script setup>
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import AppBreadcrumbs from "@/Components/AppBreadcrumbs.vue";
import AppBox from "@/Components/AppBox.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AppPagination from "@/Components/AppPagination.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import { onMounted, ref } from "vue";
import AppSearch from "@/Pages/Admin/Questions/Index/Components/AppSearch.vue";
import { useQuestionStatus } from "@/Composables/questionStatus";

const props = defineProps({
  filters: Object,
  questions: Object,
  categories: Object,
  levels: Object,
  next: Object,
});

const flashMessageComponent = ref(null);

onMounted(() => {
  flashMessageComponent.value.remover();
});

// breadcrumbs
const breadcrumbs = [
  { label: "مدیریت", url: route("admin.index") },
  { label: "سوالات", url: route("admin.questions.index") },
];

const deleteQuestion = (id) => {
  const form = useForm({
    id,
  });

  form.delete(route("admin.questions.destroy", id), {
    onSuccess: () => {
      form.reset();
      flashMessageComponent.value.remover();
    },
  });
};
</script>
