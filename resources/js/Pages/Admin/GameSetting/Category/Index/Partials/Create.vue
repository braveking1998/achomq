<template>
  <box-with-title>
    <!-- Flash messages -->
    <flash-message ref="flashMessageComponent" />

    <!-- Title -->
    <template #title>ایجاد دسته بندی جدید</template>
    <!-- Create Form -->
    <form @submit.prevent="create">
      <div class="flex flex-col gap-8 md:px-0">
        <div>
          <label for="name" class="block">نام دسته بندی</label>
          <input
            id="name"
            class="input w-1/2"
            type="text"
            v-model="form.name"
          />
          <div class="input-error" v-if="form.errors.name">
            {{ form.errors.name }}
          </div>
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
          <div class="input-error" v-if="form.errors.slug">
            {{ form.errors.slug }}
          </div>
        </div>
        <div class="flex gap-4">
          <button type="submit" class="btn-primary" :disabled="form.processing">
            ثبت دسته بندی
          </button>
          <button type="reset" class="btn-danger-border">از نوسازی</button>
        </div>
      </div>
    </form>
  </box-with-title>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import BoxWithTitle from "@/Components/BoxWithTitle.vue";
import FlashMessage from "@/Components/FlashMessage.vue";

// Handle flash messages
const flashMessageComponent = ref(null);

const form = useForm({
  name: "",
  slug: "",
});

const create = () => {
  form.post(route("admin.setting.category.store"), {
    onSuccess: () => {
      form.reset();
      flashMessageComponent.value.remover();
    },
  });
};
</script>
