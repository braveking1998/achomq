<template>
  <Head title="افزودن سوال" />
  <auth-with-sidebar-layout>
    <template #header>
      <app-breadcrumbs :breadcrumbs="breadcrumbs" />
    </template>
    <template #aside>
      <app-box class="flex flex-col gap-4 w-full p-6">
        <h1 class="text-gray-500 text-center font-bold">مشخصات سوال</h1>
        <div class="text-gray-800 text-sm flex flex-col gap-2">
          <div>نام طراح: {{ user.name }}</div>
          <div>تاریخ امروز: {{ dateFormated }}</div>
        </div>
      </app-box>
    </template>
    <template #content>
      <!-- Flash messages -->
      <flash-message ref="flashMessageComponent" varient="bg-success-500" />
      <app-box class="p-6">
        <form @submit.prevent="create">
          <div class="flex flex-col gap-4 md:px-16">
            <div class="flex flex-col gap-4 sm:flex-row justify-between">
              <div class="w-full sm:w-2/5">
                <label for="level">سطح سوال:</label>
                <select id="level" class="input" v-model.number="form.level_id">
                  <option
                    v-for="level in levels"
                    :key="level.id"
                    :value="level.id"
                  >
                    {{ level.name }}
                  </option>
                </select>
              </div>
              <div class="w-full sm:w-2/5">
                <label for="category">دسته بندی سوال:</label>
                <select
                  id="category"
                  class="input"
                  v-model.number="form.category_id"
                >
                  <option
                    v-for="category in categories"
                    :key="category.id"
                    :value="category.id"
                  >
                    {{ category.name }}
                  </option>
                </select>
              </div>
            </div>
            <hr class="mt-4" />
            <div class="mt-4">
              <label class="block" for="question">متن سوال:</label>
              <textarea
                id="question"
                placeholder="متن سوال"
                class="input"
                v-model="form.question"
              ></textarea>
              <div class="input-error" v-if="form.errors.question">
                {{ form.errors.question }}
              </div>
            </div>
            <div>
              <label for="correct">پاسخ صحیح</label>
              <input
                type="text"
                id="correct"
                placeholder="پاسخ صحیح"
                class="input"
                v-model="form.answers.correct"
              />
              <div class="input-error" v-if="form.errors[`answers.correct`]">
                {{ form.errors[`answers.correct`] }}
              </div>
            </div>
            <div>
              <label for="answer-one">پاسخ اول</label>
              <input
                type="text"
                id="answer-one"
                placeholder="پاسخ اول"
                class="input"
                v-model="form.answers.answer_one"
              />
              <div class="input-error" v-if="form.errors[`answers.answer_one`]">
                {{ form.errors[`answers.answer_one`] }}
              </div>
            </div>
            <div>
              <label for="answer-two">پاسخ دوم</label>
              <input
                type="text"
                id="answer-two"
                placeholder="پاسخ دوم"
                class="input"
                v-model="form.answers.answer_two"
              />
              <div class="input-error" v-if="form.errors[`answers.answer_two`]">
                {{ form.errors[`answers.answer_two`] }}
              </div>
            </div>
            <div>
              <label for="answer-three">پاسخ سوم</label>
              <input
                type="text"
                id="answer-three"
                placeholder="پاسخ سوم"
                class="input"
                v-model="form.answers.answer_three"
              />
              <div
                class="input-error"
                v-if="form.errors[`answers.answer_three`]"
              >
                {{ form.errors[`answers.answer_three`] }}
              </div>
            </div>
            <div class="flex flex-col md:flex-row gap-4 mt-4">
              <button type="submit" class="btn-primary">ثبت سوال</button>
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
  </auth-with-sidebar-layout>
</template>

<script setup>
import { Head, usePage, useForm } from "@inertiajs/vue3";
import AuthWithSidebarLayout from "@/Layouts/AuthWithSidebarLayout.vue";
import AppBox from "@/Components/AppBox.vue";
import { computed, ref } from "vue";
import { useShamsiNames, useShamsiDate } from "@/Composables/date.js";
import AppBreadcrumbs from "@/Components/AppBreadcrumbs.vue";
import FlashMessage from "@/Components/FlashMessage.vue";

const props = defineProps({
  levels: Object,
  categories: Object,
});

// user
const page = usePage();
const user = computed(() => page.props.auth.user);

// Handle flash messages
const flashMessageComponent = ref(null);

// breadcrumbs
const breadcrumbs = [
  { label: "داشبورد", url: route("dashboard") },
  { label: "سوالات", url: route("questions.index") },
  { label: "افزودن سوال", url: route("questions.create") },
];

// Date
const { shamsiYear, shamsiMonth, shamsiDay } = useShamsiDate();
const { shamsiDayNames } = useShamsiNames();

const day = new Date().getDay();
const dateFormated = `${shamsiDayNames[day]} ${shamsiDay} ${shamsiMonth} ماه ${shamsiYear}`;

// Form post
const form = useForm({
  level_id: props.levels[0].id ?? false,
  category_id: props.categories[0].id ?? false,
  question: null,
  answers: {
    correct: null,
    answer_one: null,
    answer_two: null,
    answer_three: null,
  },
});

const create = () =>
  form.post(route("questions.store"), {
    onSuccess: () => {
      form.reset("question", "answers");
      flashMessageComponent.value.remover();
    },
  });
</script>
