<template>
  <Head title="همه پیام ها" />
  <auth-without-sidebar-layout>
    <template #header>
      <app-breadcrumbs :breadcrumbs="breadcrumbs"> </app-breadcrumbs>
    </template>
    <template #content>
      <!-- Flash messages -->
      <flash-message ref="flashMessageComponent" />

      <app-box class="p-6">
        <table
          v-if="messages.data.length"
          class="w-full table-auto border border-gray-500 border-collapse text-base font-medium text-gray-500"
        >
          <thead>
            <tr>
              <th class="border border-gray-500 p-2 md:p-4">ردیف</th>
              <th class="border border-gray-500">عنوان</th>
              <th class="border border-gray-500">متن پیام</th>
              <th class="border border-gray-500">وضعیت</th>
              <th class="border border-gray-500">مشاهده</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(message, index) in messages.data"
              :key="message.id"
              :class="{ 'font-bold': !message.read_at }"
            >
              <td class="border border-gray-500 md:p-2 text-center">
                {{ messages.from + index }}
              </td>
              <td class="border border-gray-500 md:pr-4">
                {{ shorten(message.data.title, 10) }}
              </td>
              <td class="border border-gray-500 md:pr-4">
                {{ shorten(message.data.text, 30) }}
              </td>
              <td class="border border-gray-500 md:pr-4">
                {{ message.read_at ? "خوانده شده" : "خوانده نشده" }}
              </td>
              <td class="border border-gray-500">
                <div
                  class="flex flex-col md:flex-row gap-2 my-2 md:m-2 items-center justify-center"
                >
                  <Link
                    :href="route('messages.show', message.id)"
                    class="btn-primary text-center px-2 md:px-4"
                    >نمایش</Link
                  >
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-else class="text-center">
          <p>هیج پیامی وجود ندارد.</p>
        </div>
        <div
          v-if="messages.data.length"
          class="w-full flex justify-center my-8"
        >
          <app-pagination :links="messages.links" />
        </div>
      </app-box>
    </template>
  </auth-without-sidebar-layout>
</template>

<script setup>
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import AppBreadcrumbs from "@/Components/AppBreadcrumbs.vue";
import AppBox from "@/Components/AppBox.vue";
import AppPagination from "@/Components/AppPagination.vue";
import { Head, Link } from "@inertiajs/vue3";
import { shorten } from "@/Composables/string";
import FlashMessage from "@/Components/FlashMessage.vue";
import { ref } from "vue";

// Handle flash messages
const flashMessageComponent = ref(null);

const props = defineProps({
  messages: Object,
});

// breadcrumbs
const breadcrumbs = [
  { label: "داشبورد", url: route("dashboard") },
  { label: "همه پیام ها", url: route("messages.index") },
];
</script>
