<template>
  <Head title="بازی تک نفره" />
  <AuthWithoutSidebarLayout>
    <div
      class="hidden bg-green-500 hover:bg-green-500 !bg-green-500 hover:!bg-green-500 text-green-500 hover:text-green-500 border-green-500 hover:border-green-500"
    ></div>
    <div
      class="hidden bg-red-500 hover:bg-red-500 !bg-red-500 hover:!bg-red-500 text-red-500 hover:text-red-500 border-red-500 hover:border-red-500"
    ></div>
    <div
      class="hidden bg-blue-light hover:bg-blue-light !bg-blue-light hover:!bg-blue-light text-blue-light hover:text-blue-light border-blue-light hover:border-blue-light"
    ></div>

    <template #content>
      <Box class="container md:max-w-[50%] mx-auto" :class="`!bg-${color}`">
        <div
          class="flex flex-col gap-4 justify-center items-center text-white font-bold py-8"
        >
          <div class="w-52 h-52">
            <img src="/images/logo.png" />
          </div>
          <p>کل سوالات: {{ total }}</p>
          <p>
            پاسخ صحیح: {{ correct }}
            <span class="shadow-sm text-sm">
              ({{ earnedCoins }} سکه به دست آمد)</span
            >
          </p>
          <p>
            پاسخ اشتباه: {{ total - correct
            }}<span class="shadow-sm text-sm">
              ({{ lostCoins }} سکه از دست دادید)</span
            >
          </p>
          <Link
            class="border-2 border-white px-4 py-2 rounded-lg mt-4 hover:bg-white"
            :class="`hover:text-${color}`"
            :href="route('single-player.category')"
            >بازی مجدد</Link
          >
        </div>
      </Box>
    </template>
  </AuthWithoutSidebarLayout>
</template>
<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import Box from "@/Components/Box.vue";

defineProps({
  correct: Number,
  total: Number,
  color: String,
  earnedCoins: Number,
  lostCoins: Number,
});
</script>
