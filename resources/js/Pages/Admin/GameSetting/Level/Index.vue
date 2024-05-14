<template>
  <Head title="سطح ها" />

  <game-setting tab="level">
    <level-all :levels="levels" />
    <level-create />
  </game-setting>
</template>
<script setup>
import { Head } from "@inertiajs/vue3";
import GameSetting from "@/Layouts/GameSetting.vue";
import LevelCreate from "@/Pages/Admin/GameSetting/Level/Index/Partials/Create.vue";
import LevelAll from "@/Pages/Admin/GameSetting/Level/Index/Partials/All.vue";

defineProps({
  levels: Object,
});
</script>
