<template>
  <!-- Phones -->
  <DashboardDropdown
    :name="auth.user.name"
    :src="auth.user.chosen_image.src"
    class="block md:hidden"
  >
    <template #header>
      <PurchaseItmes :coins="auth.user.coins" :gems="auth.user.gems" />
    </template>

    <!-- Level of player -->
    <LevelOfPlayer
      class="flex items-center flex-wrap w-max m-auto relative z-50 my-4"
    />

    <div class="flex flex-col gap-4">
      <DropdownLink href="dashboard" class="border border-blue-light"
        >داشبورد</DropdownLink
      >
      <div class="flex justify-around">
        <div class="bg-gray-500 p-4 flex items-center gap-2" @click="toggle">
          <div class="text-2xl">🖥️</div>
          <div class="text-lg text-gray-100">تمام صفحه</div>
        </div>
        <Link
          class="bg-gray-500 p-4 flex items-center gap-2"
          :href="route('messages.index')"
        >
          <div class="relative text-2xl">
            <div
              class="absolute text-xs top-0 right-0 -mr-1 -mt-1"
              v-if="messages.length"
            >
              🔴
            </div>
            💬
          </div>
          <div class="text-lg text-gray-100">پیام ها</div>
        </Link>
      </div>
      <DropdownLink href="profile.index" class="border border-blue-light"
        >پروفایل</DropdownLink
      >
      <DropdownLink href="questions.index" class="border border-blue-light"
        >طراحی سوال</DropdownLink
      >
      <DropdownLink
        href="logout"
        method="post"
        as="button"
        class="text-right border border-blue-light"
        >خروج</DropdownLink
      >
    </div>
  </DashboardDropdown>
</template>

<script setup>
import LevelOfPlayer from "@/Layouts/AuthLayout/Components/LevelOfPlayer.vue";
import PurchaseItmes from "@/Layouts/AuthLayout/Components/PurchaseItems.vue";
import DashboardDropdown from "@/Layouts/AuthLayout/Components/DashboardDropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { useFullscreen } from "@vueuse/core";

const page = usePage();
const auth = computed(() => page.props.auth);
const messages = computed(() => page.props.auth.messages);

// fullscreen
const { toggle } = useFullscreen();
</script>
