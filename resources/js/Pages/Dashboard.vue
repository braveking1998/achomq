<template>
  <Head title="داشبورد" />
  <AuthWithoutSidebarLayout>
    <template #content>
      <!-- Heart -->
      <Box class="p-6">
        <div class="text-center">
          تعداد قلب های شما برای شرکت در مسابقه تک نفره:
          <span>{{ auth.user.hearts }}&nbsp;</span>
          <font-awesome-icon :icon="['fas', 'heart']" class="text-red-600" />
          <span>&nbsp;(هر یک دقیقه به شما یک قلب داده می شود.)</span>
        </div>
      </Box>

      <!-- Matches -->
      <div
        class="flex flex-col md:flex-row gap-4 md:gap-16 justify-center items-center mt-8"
      >
        <Link :href="route('single-player.category')" class="btn-dashboard"
          >مسابقه تک نفره</Link
        >
        <Link
          :href="route('multi-player.index')"
          class="btn-dashboard text-red-500 border-red-500 hover:bg-red-500"
          >مسابقه دو نفره</Link
        >
        <Link
          :href="route('single-player.category')"
          class="btn-dashboard text-green-500 border-green-500 hover:bg-green-500"
          >مسابقه گروهی</Link
        >
      </div>

      <!-- Events -->
      <Box class="mt-8 p-6">
        <div class="flex gap-2 relative">
          <h1>رویداد های هفتگی</h1>
          <span
            class="bg-gray-200 border border-gray-700 text-gray-700 p-1 rounded-full w-9 h-9 text-center font-bold text-lg relative -mt-4 cursor-pointer"
            @click="help = !help"
            >؟</span
          >
          <div
            class="rounded-sm bg-gray-200 py-2 px-4 w-60 absolute -mt-28 right-28"
            v-show="help"
          >
            این راهنمای بازی پرسش و پاسخ اچم کیو می باشد، لطفا در صورت نیاز
            استفاده کنید.
          </div>
        </div>
      </Box>
    </template>
  </AuthWithoutSidebarLayout>
</template>

<script setup>
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import Box from "@/Components/Box.vue";
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const auth = computed(() => page.props.auth);

const help = ref(false);
</script>
