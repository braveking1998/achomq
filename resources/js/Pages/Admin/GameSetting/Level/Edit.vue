<template>
  <Head title="ویرایش سطح" />
  <auth-without-sidebar-layout>
    <!-- breadcrumbs -->
    <template #header>
      <app-breadcrumbs :breadcrumbs="breadcrumbs" />
    </template>

    <!-- Content -->
    <template #content>
      <!-- Flash messages -->
      <flash-message ref="flashMessageComponent" />

      <!-- Main Content -->
      <app-box class="p-6">
        <!-- Edit Form -->
        <form @submit.prevent="">
          <div class="flex flex-col gap-4">
            <!-- Edit level -->
            <box-with-title>
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
            </box-with-title>

            <!-- Question makers settings -->
            <box-with-title>
              <!-- Title -->
              <template #title> تنظیمات طراحی سوال </template>
              <!-- Content -->
              <template #default>
                <!-- Point increase -->
                <div>
                  <label for="add_question" class="block"
                    >میزان افزایش امتیاز</label
                  >
                  <input
                    dir="ltr"
                    id="add_question"
                    class="input w-1/2"
                    type="number"
                    v-model.number="form.add_question_points"
                  />
                  <div
                    class="input-error"
                    v-if="form.errors.add_question_points"
                  >
                    {{ form.errors.add_question_points }}
                  </div>
                </div>

                <!-- Coins increase -->
                <div>
                  <label for="add_question" class="block"
                    >میزان افزایش سکه</label
                  >
                  <input
                    dir="ltr"
                    id="add_question"
                    class="input w-1/2"
                    type="number"
                    v-model.number="form.add_question_coins"
                  />
                  <div
                    class="input-error"
                    v-if="form.errors.add_question_coins"
                  >
                    {{ form.errors.add_question_coins }}
                  </div>
                </div>
              </template>
            </box-with-title>

            <!-- Single player setting -->
            <box-with-title>
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
                  <button @click="update" class="btn-primary">ثبت سطح</button>
                  <button @click="undoChanges" class="btn-danger-border">
                    از نوسازی
                  </button>
                </div>
              </template>
            </box-with-title>
          </div>
        </form>
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

// Handle flash messages
const flashMessageComponent = ref(null);

const props = defineProps({
  level: Object,
  perks: Object,
  features: Object,
});

// breadcrumbs
const breadcrumbs = [
  { label: "مدیریت", url: route("admin.index") },
  { label: "تنظیمات بازی", url: route("admin.setting.level.index") },
];

const form = useForm({
  name: props.level.name ?? "",
  slug: props.level.slug ?? "",
  max: props.level.max ?? 0,
  win_coins: props.features.win_coins ?? 0,
  lose_coins: props.features.lose_coins ?? 0,
  points: props.features.points ?? 0,
  time: props.features.time ?? 0,
  add_question_points: props.perks.add_question_points ?? 0,
  add_question_coins: props.perks.add_question_coins ?? 0,
});

const update = () => {
  form.put(route("admin.setting.level.update", props.level.id), {
    onSuccess: () => {
      flashMessageComponent.value.remover();
    },
  });
};

const undoChanges = () => {
  form.name = props.level.slug;
  form.slug = props.level.slug;
  form.max = props.level.max;
  form.win_coins = props.features.win_coins;
  form.lose_coins = props.features.lose_coins;
  form.points = props.features.points;
  form.time = props.features.time;
  add_question_points = props.perks.add_question_points;
  add_question_coins = props.perks.add_question_coins;
};
</script>
