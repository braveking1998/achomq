<template>
  <Head title="بازی تک نفره" />
  <auth-without-sidebar-layout>
    <template #header>
      <app-breadcrumbs :breadcrumbs="breadcrumbs" />
    </template>
    <template #content>
      <app-box class="container md:max-w-[50%] mx-auto" :class="`!bg-${color}`">
        <div
          class="flex flex-col gap-4 justify-center items-center text-white font-bold py-8"
        >
          <div class="w-52 h-52">
            <img src="/images/logo.webp" />
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
            :href="route('single.index')"
            >بازی مجدد</Link
          >
        </div>
      </app-box>
    </template>
  </auth-without-sidebar-layout>
</template>
<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import AppBox from "@/Components/AppBox.vue";
import AppBreadcrumbs from "@/Components/AppBreadcrumbs.vue";

defineProps({
  correct: Number,
  total: Number,
  color: String,
  earnedCoins: Number,
  lostCoins: Number,
});

// breadcrumbs
const breadcrumbs = [{ label: "داشبورد", url: route("dashboard") }];
</script>
