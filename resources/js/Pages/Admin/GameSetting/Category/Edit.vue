<template>
  <Head title="ویرایش دسته بندی" />

  <auth-without-sidebar-layout>
    <template #header>
      <!-- breadcrumbs -->
      <app-breadcrumbs :breadcrumbs="breadcrumbs" />
    </template>
    <template #content>
      <!-- Flash messages -->
      <flash-message ref="flashMessageComponent" />

      <app-box class="p-6">
        <!-- Content -->
        <box-with-title>
          <!-- Title -->
          <template #title>ویرایش دسته بندی</template>
          <!-- Edut Form -->
          <form @submit.prevent="update">
            <div class="flex flex-col gap-8 md:px-0">
              <div>
                <label for="name" class="block">نام دسته بندی</label>
                <input
                  id="name"
                  class="input w-1/2"
                  type="text"
                  v-model="form.name"
                />
              </div>
              <div>
                <label for="slug" class="block">اسلاگ دسته بندی</label>
                <input
                  dir="ltr"
                  id="slug"
                  class="input w-1/2"
                  type="text"
                  v-model="form.slug"
                />
              </div>
              <div class="flex gap-4">
                <button type="submit" class="btn-primary">ثبت دسته بندی</button>
                <button type="reset" class="btn-bordered">از نوسازی</button>
              </div>
            </div>
          </form>
        </box-with-title>
      </app-box>
    </template>
  </auth-without-sidebar-layout>
</template>

<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import AppBreadcrumbs from "@/Components/AppBreadcrumbs.vue";
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import AppBox from "@/Components/AppBox.vue";
import BoxWithTitle from "@/Components/BoxWithTitle.vue";
import { ref } from "vue";
import FlashMessage from "@/Components/FlashMessage.vue";

const props = defineProps({
  category: Object,
  previous: String,
});

// Handle flash messages
const flashMessageComponent = ref(null);

// breadcrumbs
const breadcrumbs = [
  { label: "پنل ادمین", url: route("admin.index") },
  { label: "تنظیمات بازی", url: props.previous },
];

const form = useForm({
  name: props.category.name,
  slug: props.category.slug,
});

const update = () => {
  form.put(route("admin.setting.category.update", props.category.id), {
    onSuccess: () => {
      flashMessageComponent.value.remover();
    },
  });
};
</script>
