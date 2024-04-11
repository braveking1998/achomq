<template>
  <Head title="ویرایش دسته بندی" />

  <AuthWithoutSidebarLayout>
    <template #header>
      <!-- breadcrumbs -->
      <Breadcrumbs :breadcrumbs="breadcrumbs" />
    </template>
    <template #content>
      <!-- Flash messages -->
      <div
        v-show="flashMessage && flashMessageVisible"
        @click="flashMessageVisible = !flashMessageVisible"
        class="flash-message"
      >
        {{ flashMessage }}
      </div>
      <Box class="p-6">
        <!-- Content -->
        <BoxWithTitle>
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
        </BoxWithTitle>
      </Box>
    </template>
  </AuthWithoutSidebarLayout>
</template>

<script setup>
import { Head, useForm, usePage } from "@inertiajs/vue3";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import Box from "@/Components/Box.vue";
import BoxWithTitle from "@/Components/BoxWithTitle.vue";
import { computed, ref } from "vue";

const props = defineProps({
  category: Object,
  previous: String,
});

// Handle flash messages
const page = usePage();
const flashMessage = computed(() => {
  return page.props.flash.success;
});

const flashMessageVisible = ref(true);
const flashMessageVisibleChange = (time) => {
  setTimeout(() => {
    flashMessageVisible.value = false;
  }, time);
};

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
      flashMessageVisible.value = true;

      flashMessageVisibleChange(2000);
    },
  });
};
</script>
