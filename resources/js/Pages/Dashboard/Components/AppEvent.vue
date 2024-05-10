<template>
  <app-box class="mt-8 p-6 bg-opacity-20">
    <div class="flex gap-2 relative opacity-20">
      <h1>رویداد های هفتگی</h1>
      <span
        class="bg-gray-200 border border-gray-700 text-gray-700 p-1 rounded-full w-9 h-9 text-center font-bold text-lg relative -mt-4 cursor-not-allowed"
        >؟</span
      >
      <div
        class="rounded-sm bg-gray-200 py-2 px-4 w-60 absolute -mt-28 right-28"
        v-show="help"
      >
        این راهنمای بازی پرسش و پاسخ اچم کیو می باشد، لطفا در صورت نیاز استفاده
        کنید.
      </div>
    </div>
    <div class="mt-4">
      <p class="text-center opacity-100">
        به زودی از این بخش رونمایی خواهد شد.
      </p>
    </div>
  </app-box>
</template>
<script setup>
import AppBox from "@/Components/AppBox.vue";
import { ref } from "vue";

const help = ref(false);
</script>
