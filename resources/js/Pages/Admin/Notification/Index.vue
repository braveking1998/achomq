<template>
  <Head title="همه پیام ها" />
  <AuthWithoutSidebarLayout>
    <template #header>
      <Breadcrumbs :breadcrumbs="breadcrumbs">
        <template #right-side>
          <Link
            :href="route('admin.notification.create')"
            class="btn-primary hidden md:block"
            >پیام جدید</Link
          >
        </template>
      </Breadcrumbs>
    </template>
    <template #content>
      <!-- Flash messages -->
      <FlashMessage ref="messageComponent" />

      <Box class="p-6">
        <table
          class="w-full table-auto border border-gray-500 border-collapse text-base font-medium text-gray-500"
        >
          <thead>
            <tr>
              <th class="border border-gray-500 p-2 md:p-4">ردیف</th>
              <th class="border border-gray-500">عنوان</th>
              <th class="border border-gray-500">متن پیام</th>
              <th class="border border-gray-500">عملیات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(message, index) in messages.data" :key="message.id">
              <td class="border border-gray-500 md:p-2 text-center">
                {{ messages.from + index }}
              </td>
              <td class="border border-gray-500 md:pr-4">
                {{ shorten(message.title, 10) }}
              </td>
              <td class="border border-gray-500 md:pr-4">
                {{ shorten(message.text, 30) }}
              </td>
              <td class="border border-gray-500">
                <div
                  class="flex flex-col md:flex-row gap-2 my-2 md:m-2 items-center justify-center"
                >
                  <Link
                    :href="route('admin.notification.show', message.id)"
                    class="btn-primary text-center px-2 md:px-4"
                    >نمایش</Link
                  >
                  <button
                    @click="deleteMessage(message.id)"
                    class="btn-primary text-center bg-red-500 px-2 md:px-4"
                  >
                    حذف
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <div
          v-if="messages.data.length"
          class="w-full flex justify-center my-8"
        >
          <Pagination :links="messages.links" />
        </div>
      </Box>
    </template>
  </AuthWithoutSidebarLayout>
</template>

<script setup>
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import Box from "@/Components/Box.vue";
import Pagination from "@/Components/Pagination.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { shorten } from "@/Composables/string";
import FlashMessage from "@/Components/FlashMessage.vue";

const props = defineProps({
  messages: Object,
});

// breadcrumbs
const breadcrumbs = [{ label: "مدیریت", url: route("admin.index") }];

// Handle flash messages
const messageComponent = ref(null);

const deleteMessage = (id) => {
  const form = useForm({
    id: id,
  });

  form.delete(route("admin.notification.destroy", id), {
    onSuccess: () => {
      form.reset();
      messageComponent.value.remover();
    },
  });
};
</script>
