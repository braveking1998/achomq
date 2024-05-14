<template>
  <Head title="آمار سوالات" />
  <game-setting tab="stats">
    <!-- Levels -->
    <div class="flex gap-4 mb-8 flex-wrap">
      <!-- Levels loop -->
      <button
        class="btn-bordered"
        :class="{ 'btn-primary': clickedLevel === level.id }"
        v-for="level in levels"
        :key="level.id"
        @click="clickedLevel = level.id"
      >
        {{ level.name }}
      </button>
    </div>
    <!-- Categories -->
    <div>
      <!-- Content -->
      <ul class="mr-8 flex flex-col gap-4">
        <!-- Categories Loop -->
        <li
          class="flex gap-12 text-lg"
          v-for="category in categories"
          :key="category.id"
        >
          <div>{{ category.name }}</div>
          <div>{{ category.questions_count }}</div>
        </li>
      </ul>
    </div>
  </game-setting>
</template>

<script setup>
import { ref, watch } from "vue";
import { debounce } from "lodash";
import { router, Head } from "@inertiajs/vue3";
import GameSetting from "@/Layouts/GameSetting.vue";

const props = defineProps({
  levels: Object,
  categories: Object,
});

const clickedLevel = ref(props.levels[0].id);

watch(
  clickedLevel,
  debounce(
    () =>
      router.get(
        route("admin.setting.stats"),
        { level: clickedLevel.value },
        {
          preserveState: true,
          preserveScroll: true,
        }
      ),
    1000
  )
);
</script>
