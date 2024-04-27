<template>
  <div>
    <div class="flex justify-center items-center gap-8">
      <!-- Level of player -->
      <LevelOfPlayer
        class="flex items-center flex-wrap w-max m-auto relative z-50"
      />
      <PurchaseItmes :coins="auth.user.coins" :gems="auth.user.gems" />
    </div>
    <div class="flex justify-center items-center gap-2 lg:gap-8">
      <div
        class="text-2xl hover:bg-amber-100 p-2 lg:p-4 cursor-pointer"
        @click="toggle"
      >
        🖥️
      </div>
      <div
        class="relative hover:bg-amber-100 p-4"
        id="toggleMessages"
        @click="toggleMenu('message')"
      >
        <div class="relative text-2xl cursor-pointer" id="toggleMessages">
          <div
            class="absolute text-xs top-0 right-0 -mr-1 -mt-1"
            id="toggleMessages"
            v-if="messages.length"
          >
            🔴
          </div>
          💬
        </div>
        <div
          v-if="isMessageCenterOpen"
          class="bg-amber-100 absolute top-16 left-0 w-64 flex flex-col"
        >
          <div class="flex justify-between bg-gray-400 p-2">
            <div>اعلانات</div>
            <div>
              <Link
                :href="route('messages.index')"
                class="text-indigo-500 underline text-sm"
                >مشاهده همه</Link
              >
            </div>
          </div>
          <div class="py-4 flex flex-col items-center gap-2">
            <div v-if="messages.length">
              <Message
                v-for="message in messages"
                href="messages.index"
                :title="message.data.title"
                :image="message.data.image"
                :date="message.created_at"
              />
            </div>
            <div v-else><p>هیج پیام جدیدی وجود ندارد.</p></div>
          </div>
        </div>
      </div>
      <div class="flex items-center gap-4 relative">
        <div class="w-24 h-24 border-2 border-gray-700 p-1 rounded-full">
          <img
            :src="auth.user.chosen_image.src"
            alt="profile"
            class="w-full h-full rounded-full"
          />
        </div>
        <div class="font-bold text-lg text-gray-700">{{ auth.user.name }}</div>
        <div
          class="mt-2 cursor-pointer"
          id="toggleMenu"
          @click="toggleMenu('menu')"
        >
          ▼
        </div>
        <div
          v-if="isMenu"
          class="absolute top-28 left-4 bg-amber-100 p-4 flex flex-col gap-4 w-56"
        >
          <DropdownLink href="dashboard">داشبورد</DropdownLink>
          <DropdownLink href="questions.index">طراحی سوال</DropdownLink>
          <DropdownLink href="profile.index">پروفایل</DropdownLink>
          <DropdownLink
            href="logout"
            method="post"
            as="button"
            class="text-right"
            >خروج</DropdownLink
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import LevelOfPlayer from "@/Layouts/AuthLayout/Components/LevelOfPlayer.vue";
import PurchaseItmes from "@/Layouts/AuthLayout/Components/PurchaseItems.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Message from "@/Layouts/AuthLayout/Components/Message.vue";
import { ref, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { useFullscreen } from "@vueuse/core";

const page = usePage();
const auth = computed(() => page.props.auth);
const messages = computed(() => page.props.auth.messages);

const isMenu = ref(false);
const isMessageCenterOpen = ref(false);

const toggleMenu = (which) => {
  if (which == "message") {
    isMessageCenterOpen.value = !isMessageCenterOpen.value;

    if (isMenu.value === true) {
      isMenu.value = false;
    }
  } else {
    isMenu.value = !isMenu.value;

    if (isMessageCenterOpen.value === true) {
      isMessageCenterOpen.value = false;
    }
  }
};

// fullscreen
const { toggle } = useFullscreen();
</script>
