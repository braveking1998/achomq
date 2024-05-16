<template>
  <app-box class="p-6 mb-6">
    <form @submit.prevent="filter">
      <div class="grid grid-cols-1 md:grid-cols-4 place-content-center">
        <div class="flex items-center justify-center gap-4">
          <label for="category" class="w-1/4 md:w-auto">دسته بندی:</label>
          <select id="category" class="input w-2/3" v-model="form.category">
            <option value="0" selected>همه دسته بندی ها</option>
            <option
              v-for="category in categories"
              :key="category.id"
              :value="category.id"
            >
              {{ category.name }}
            </option>
          </select>
        </div>
        <div class="flex items-center justify-center gap-4">
          <label for="level" class="w-1/4 md:w-auto">سطح:</label>
          <select id="level" class="input w-2/3" v-model="form.level">
            <option value="0" selected>همه سطوح</option>
            <option v-for="level in levels" :key="level.id" :value="level.id">
              {{ level.name }}
            </option>
          </select>
        </div>
        <div class="flex items-center justify-center gap-4">
          <label for="level" class="w-1/4 md:w-auto">وضعیت:</label>
          <select id="level" class="input w-2/3" v-model="form.status">
            <option value="0" selected>همه وضعیت ها</option>
            <option v-for="st in status" :key="st.value" :value="st.value">
              {{ st.title }}
            </option>
          </select>
        </div>
        <div class="flex items-center justify-center gap-4">
          <input
            type="text"
            placeholder="متن خود را جستجو کنید"
            class="input w-2/3"
            v-model="form.text"
          />
          <button type="submit" class="btn-primary mt-2">جستجو</button>
        </div>
      </div>
    </form>
  </app-box>
</template>
<script setup>
import AppBox from "@/Components/AppBox.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  filters: Object,
  categories: Object,
  levels: Object,
});

const status = [
  {
    title: "تایید نشده",
    value: -1,
  },
  {
    title: "معلق",
    value: 1,
  },
  {
    title: "تایید شده",
    value: 2,
  },
];

const form = useForm({
  category: props.filters.category ?? 0,
  level: props.filters.level ?? 0,
  status: props.filters.status ?? 0,
  text: props.filters.text ?? "",
});

const filter = () =>
  form.get(route("admin.questions.index"), {
    preserveScroll: true,
  });
</script>
