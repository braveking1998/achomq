<template>
  <Link :href="route(href)">
    <div class="flex items-center gap-4">
      <div class="border-2 border-gray-700 p-1 rounded-full w-16">
        <img :src="image" alt="image" class="w-full h-full rounded-full" />
      </div>
      <div class="font-bold text-lg text-gray-700 flex flex-col gap-2 w-32">
        <p class="text-xs">{{ shorten(title, 10) ?? "متن مشخص نیست" }}</p>
        <p class="text-xs text-gray-500">
          <span>🕛 </span>{{ dateTr(timeAgo) ?? "نامشخص" }}
        </p>
      </div>
    </div>
  </Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { shorten, dateTr } from "@/Composables/string";
import { useTimeAgo } from "@vueuse/core";

const props = defineProps({
  href: {
    type: String,
    required: true,
  },
  title: String,
  image: String,
  date: String,
});

const timeAgo = useTimeAgo(new Date(props.date));
</script>
