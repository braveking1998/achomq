<template>
  <div>
    <app-box class="p-6">
      <div class="flex justify-between items-center">
        <div>
          <span
            v-for="(breadcrumb, index) in breadcrumbs"
            :key="index"
            class="text-gray-500"
          >
            <Link :href="breadcrumb.url">{{ breadcrumb.label }}</Link>
            <span v-if="index < breadcrumbs.length - 1"> / </span>
          </span>
        </div>
        <div>
          <slot name="right-side"></slot>
        </div>
      </div>
    </app-box>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import AppBox from "@/Components/AppBox.vue";

defineProps({
  breadcrumbs: Object,
});
</script>
