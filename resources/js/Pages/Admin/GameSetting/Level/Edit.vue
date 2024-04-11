<template>
  <Head title="ویرایش سطح" />
  <AuthWithoutSidebarLayout>
    <!-- breadcrumbs -->
    <template #header>
      <Breadcrumbs :breadcrumbs="breadcrumbs" />
    </template>

    <!-- Content -->
    <template #content>
      <!-- Flash messages -->
      <div
        v-show="flashMessage && flashMessageVisible"
        @click="flashMessageVisible = !flashMessageVisible"
        class="flash-message"
      >
        {{ flashMessage }}
      </div>

      <!-- Main Content -->
      <Box class="p-6">
        <!-- Edit Form -->
        <form @submit.prevent="update">
          <div class="flex flex-col gap-4">
            <!-- Edit level -->
            <BoxWithTitle>
              <!-- Title -->
              <template #title>ویرایش سطح ها</template>
              <!-- Level name -->
              <div>
                <label for="name" class="block">نام سطح</label>
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
                <div class="input-error" v-if="form.errors.slug">
                  {{ form.errors.slug }}
                </div>
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
                <div class="input-error" v-if="form.errors.max">
                  {{ form.errors.max }}
                </div>
              </div>
            </BoxWithTitle>

            <!-- Question makers settings -->
            <BoxWithTitle>
              <!-- Title -->
              <template #title> تنظیمات طراحی سوال </template>
              <!-- Content -->
              <template #default>
                <!-- Points increase -->
                <div>
                  <label for="add_question" class="block"
                    >میزان افزایش امتیاز</label
                  >
                  <input
                    dir="ltr"
                    id="add_question"
                    class="input w-1/2"
                    type="number"
                    v-model.number="form.add_question"
                  />
                  <div class="input-error" v-if="form.errors.add_question">
                    {{ form.errors.add_question }}
                  </div>
                </div>
              </template>
            </BoxWithTitle>

            <!-- Single player setting -->
            <BoxWithTitle>
              <!-- Title -->
              <template #title> تنظیمات بازی تک نفره </template>

              <!-- Content -->
              <template #default>
                <!-- Coins increase -->
                <div>
                  <label for="win_coins" class="block">میزان افزایش سکه</label>
                  <input
                    dir="ltr"
                    id="win_coins"
                    class="input w-1/2"
                    type="number"
                    v-model.number="form.win_coins"
                  />
                  <div class="input-error" v-if="form.errors.win_coins">
                    {{ form.errors.win_coins }}
                  </div>
                </div>

                <!-- Coins decrease -->
                <div>
                  <label for="lose_coins" class="block">میزان کاهش سکه</label>
                  <input
                    dir="ltr"
                    id="lose_coins"
                    class="input w-1/2"
                    type="number"
                    v-model.number="form.lose_coins"
                  />
                  <div class="input-error" v-if="form.errors.lose_coins">
                    {{ form.errors.lose_coins }}
                  </div>
                </div>

                <!-- Points increase -->
                <div>
                  <label for="points" class="block">میزان افزایش امتیاز</label>
                  <input
                    dir="ltr"
                    id="points"
                    class="input w-1/2"
                    type="number"
                    v-model.number="form.points"
                  />
                  <div class="input-error" v-if="form.errors.points">
                    {{ form.errors.points }}
                  </div>
                </div>

                <!-- Time per question / ms -->
                <div>
                  <label for="time" class="block">زمان هر سوال</label>
                  <p class="text-gray-400 text-xs my-2">* بر اساس ثانیه</p>
                  <input
                    dir="ltr"
                    id="time"
                    class="input w-1/2"
                    type="number"
                    v-model.number="form.time"
                  />
                  <div class="input-error" v-if="form.errors.time">
                    {{ form.errors.time }}
                  </div>
                </div>

                <!-- Submit -->
                <div class="flex gap-4">
                  <button type="submit" class="btn-primary">ثبت سطح</button>
                  <button type="reset" class="btn-bordered">از نوسازی</button>
                </div>
              </template>
            </BoxWithTitle>
          </div>
        </form>
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
  level: Object,
  previous: String,
  win_coins: Number,
  lose_coins: Number,
  points: Number,
  time: Number,
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
  name: props.level.name ?? "",
  slug: props.level.slug ?? "",
  max: props.level.max ?? 0,
  add_question: props.level.add_question ?? 0,
  win_coins: props.win_coins ?? 0,
  lose_coins: props.lose_coins ?? 0,
  points: props.points ?? 0,
  time: props.time ?? 0,
});

const update = () => {
  form.put(route("admin.setting.level.update", props.level.id), {
    onSuccess: () => {
      flashMessageVisible.value = true;

      flashMessageVisibleChange(2000);
    },
  });
};
</script>
