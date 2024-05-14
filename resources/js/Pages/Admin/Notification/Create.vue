<template>
  <Head title="افزودن سوال" />

  <auth-without-sidebar-layout>
    <template #header>
      <app-breadcrumbs :breadcrumbs="breadcrumbs" />
    </template>

    <template #content>
      <app-box class="p-6">
        <div
          v-if="flashMessage"
          class="text-center bg-green-500 px-6 py-2 w-2/3 mx-auto mb-5 text-white"
        >
          {{ flashMessage }}
        </div>
        <form @submit.prevent="create">
          <div class="flex flex-col gap-4 md:px-16">
            <div>
              <div
                class="flex flex-col md:flex-row justify-center md:items-center gap-4"
              >
                <label for="selected-users" class="w-full md:w-4/12 lg:w-2/12"
                  >انتخاب کاربران</label
                >
                <select
                  id="selected-users"
                  class="input"
                  v-model="form.selectedUsers"
                  multiple
                >
                  <option value="all" selected>همه کاربران</option>
                  <option v-for="user in users" :key="user.id" :value="user.id">
                    {{ user.name }}
                  </option>
                </select>
              </div>
              <div class="input-error" v-if="form.errors.selectedUsers">
                {{ form.errors.selectedUsers }}
              </div>
            </div>
            <div>
              <label for="title" class="block">عنوان</label>
              <input
                type="text"
                id="title"
                v-model="form.title"
                class="mt-4 w-full"
              />
              <div class="input-error" v-if="form.errors.title">
                {{ form.errors.title }}
              </div>
            </div>
            <div>
              <h3 class="block">انتخاب عکس پیام</h3>
              <div class="flex gap-12 flex-wrap mt-4">
                <div
                  class="w-24 h-24 relative"
                  v-for="image in images"
                  :key="image.id"
                >
                  <img
                    :src="image.src"
                    :alt="image.type"
                    class="w-full h-full hover:opacity-60 hover:cursor-pointer hover:border-green-500 hover:border-4"
                    @click="imageSelector(image.src, image.id)"
                    :class="
                      selectedImage == image.id
                        ? 'border-green-500 border-4'
                        : ''
                    "
                  />
                </div>
              </div>
              <div class="input-error" v-if="form.errors.image">
                {{ form.errors.image }}
              </div>
            </div>
            <div>
              <label for="text" class="block">پیام</label>
              <textarea
                id="text"
                v-model="form.text"
                class="mt-4 w-full"
                rows="8"
              ></textarea>
              <div class="input-error" v-if="form.errors.text">
                {{ form.errors.text }}
              </div>
            </div>
            <div class="flex flex-col md:flex-row gap-4 mt-4">
              <button type="submit" class="btn-primary">ارسال پیام</button>
              <button
                type="rest"
                class="btn-bordered"
                @click.prevent="form.reset()"
              >
                از نو سازی
              </button>
            </div>
          </div>
        </form>
      </app-box>
    </template>
  </auth-without-sidebar-layout>
</template>

<script setup>
import { Head, useForm, usePage } from "@inertiajs/vue3";
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import AppBox from "@/Components/AppBox.vue";
import AppBreadcrumbs from "@/Components/AppBreadcrumbs.vue";
import { computed, ref } from "vue";

defineProps({
  users: Object,
  images: Object,
});

const page = usePage();
// Handle flash messages
const flashMessage = computed(() => {
  return page.props.flash.success;
});

// breadcrumbs
const breadcrumbs = [
  { label: "مدیریت", url: route("admin.index") },
  { label: "همه پیام ها", url: route("admin.notification.index") },
];

// Form post
const form = useForm({
  selectedUsers: ["all"],
  title: "",
  text: "",
  image: "",
});

const create = () =>
  form.post(route("admin.notification.store"), {
    onSuccess: () => {
      form.reset("text", "title", "selectedUsers");
      selectedImage.value = false;
    },
  });

const selectedImage = ref(false);

const imageSelector = (src, id) => {
  form.image = src;
  selectedImage.value = id;
};
</script>
