<template>
  <box-with-title>
    <!-- Flash messages -->
    <div
      v-show="flashMessage && flashMessageVisible"
      @click="flashMessageVisible = !flashMessageVisible"
      class="flash-message"
    >
      {{ flashMessage }}
    </div>
    <!-- Title -->
    <template #title>ایجاد سطح جدید</template>
    <!-- Create form -->
    <form @submit.prevent="create">
      <div class="flex flex-col gap-8 md:px-0">
        <!-- Level name -->
        <div>
          <label for="name" class="block">نام سطح</label>
          <input
            id="name"
            class="input w-1/2"
            type="text"
            v-model="form.name"
          />
        </div>
        <!-- Level slug -->
        <div>
          <label for="slug" class="block">اسلاگ سطح</label>
          <input
            dir="ltr"
            id="slug"
            class="input w-1/2"
            type="text"
            v-model="form.slug"
          />
        </div>
        <!-- Level max -->
        <div>
          <label for="max" class="block">بالاترین امتیاز سطح</label>
          <input
            dir="ltr"
            id="max"
            class="input w-1/2"
            type="number"
            v-model.number="form.max"
          />
        </div>
        <!-- Submit -->
        <div class="flex gap-4">
          <button type="submit" class="btn-primary">ثبت سطح</button>
          <button type="reset" class="btn-bordered">از نوسازی</button>
        </div>
      </div>
    </form>
  </box-with-title>
</template>

<script setup>
import BoxWithTitle from "@/Components/BoxWithTitle.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

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

const form = useForm({
  name: "",
  slug: "",
  max: 0,
});

const create = () => {
  form.post(route("admin.setting.level.store"), {
    onSuccess: () => {
      flashMessageVisible.value = true;

      flashMessageVisibleChange(2000);
    },
  });
};
</script>
