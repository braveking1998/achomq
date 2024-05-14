<template>
  <Head title="اچم کیو" />
  <guest-layout title="صفحه نخست">
    <!-- Games -->
    <!-- Games: phones -->
    <section class="md:hidden mx-2 mt-8">
      <app-slider
        :data="games"
        v-slot="{ x }"
        class="flex justify-center items-center gap-4"
      >
        <div
          class="group w-2/3 md:w-1/3 lg:w-1/4 min-h-[250px] border border-gray-300 p-4 rounded-lg flex flex-col items-center gap-4 hover:bg-gray-600 hover:text-gray-300 [&_img]:w-full"
        >
          <div
            class="group-hover:bg-gray-400 w-28 border border-gray-800 text-center p-2 rounded-full bg-white"
          >
            <img :src="games[x].image" :alt="games[x].title" />
          </div>
          <div class="font-bold">
            {{ games[x].title }}
          </div>
          <div class="text-justify">
            {{ games[x].description }}
          </div>
        </div>
      </app-slider>
    </section>

    <!-- Games: computers -->
    <section
      class="hidden md:flex justify-center items-center gap-8 lg:gap-12 mx-4 mt-8 lg:my-12"
    >
      <div
        v-for="game in games"
        :key="game.title"
        class="group w-2/3 md:w-1/3 lg:w-1/4 min-h-[250px] border border-gray-300 p-4 rounded-lg flex flex-col items-center gap-4 hover:bg-gray-600 hover:text-gray-300 [&_img]:w-full"
      >
        <div
          class="group-hover:bg-gray-400 w-28 border border-gray-800 text-center p-2 rounded-full bg-white"
        >
          <img :src="game.image" :alt="game.title" />
        </div>
        <div class="font-bold">
          {{ game.title }}
        </div>
        <div class="text-justify">
          {{ game.description }}
        </div>
      </div>
    </section>

    <!-- The 3 tops -->
    <!-- The 3 tops: phones -->
    <section
      class="sm:hidden bg-[url('/images/top-users.webp')] bg-no-repeat bg-cover bg-center w-full pt-16 my-8"
    >
      <app-slider
        :data="topUsers"
        v-slot="{ x }"
        class="flex justify-center items-center gap-4"
      >
        <!-- content -->
        <div
          class="bg-gray-200 pt-10 border-t-4 border-t-blue-950 basis-36 text-base text-center hover:bg-purple-400 hover:border-t-red-800 transition-ease-out-500 h-36"
        >
          <img
            :src="topUsers[x].image"
            class="absolute w-12 mt-[-75px] mr-11"
          />
          <div class="mt-10">{{ topUsers[x].name }}</div>
        </div>
      </app-slider>
    </section>

    <!-- The 3 tops: computers -->
    <section
      class="hidden bg-[url('/images/top-users.webp')] bg-no-repeat bg-cover bg-center sm:flex w-full pt-16 justify-center items-end gap-8 my-8"
    >
      <div
        v-for="user in topUsers"
        :key="user.name"
        class="bg-gray-200 pt-10 border-t-4 border-t-blue-950 basis-36 text-base text-center hover:bg-purple-400 hover:border-t-red-800 transition-ease-out-500"
        :class="[user.order, user.height]"
      >
        <img :src="user.image" class="absolute w-12 mt-[-75px] mr-11" />
        <div class="mt-2">{{ user.name }}</div>
      </div>
    </section>

    <!-- Sponsors -->
    <!-- Sponsors: phones -->
    <section class="sm:hidden">
      <app-slider
        :data="sponsors"
        v-slot="{ x }"
        class="flex justify-center items-center gap-2"
      >
        <div class="group sm:w-1/4 hover:opacity-70 transition-ease-out-500">
          <a href="#" target="_blank" rel="noopener noreferrer" class="block">
            <img
              :src="sponsors[x].url"
              :title="sponsors[x].name"
              class="block m-auto p-4 group-hover:p-0"
            />
          </a>
        </div>
      </app-slider>
    </section>

    <!-- Sponsors: computers -->
    <section class="hidden my-12 sm:flex items-center justify-center sm:gap-8">
      <div
        v-for="sponsor in sponsors"
        class="sm:w-1/4 hover:opacity-70 transition-ease-out-500"
        :key="sponsor.name"
      >
        <a href="#" target="_blank" rel="noopener noreferrer" class="block">
          <img
            :src="sponsor.url"
            :title="sponsor.name"
            class="block m-auto p-4"
          />
        </a>
      </div>
    </section>
  </guest-layout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { onMounted } from "vue";
import AppSlider from "@/Components/AppSlider.vue";

const props = defineProps({
  topUsers: Object,
});

const medals = [
  {
    image: "/images/medals/gold.webp",
    order: "order-2",
    height: "h-32",
  },
  {
    image: "/images/medals/silver.webp",
    order: "order-3",
    height: "h-28",
  },
  {
    image: "/images/medals/bronze.webp",
    order: "order-1",
    height: "h-24",
  },
];

onMounted(() => {
  props.topUsers.forEach((x, index) => {
    Object.assign(x, medals[index]);
  });
});

const games = [
  {
    image: "/images/group-game.webp",
    title: "گروهی",
    description: "شما می توانید به صورت گروهی با دوستان خود رقابت کنید",
  },
  {
    image: "/images/multi-player.webp",
    title: "دو نفره",
    description:
      "شما می توانید به صورت دو نفره با دوستان خود و به صورت تصادفی رقابت کنید",
  },
  {
    image: "/images/single-player.webp",
    title: "تک نفره",
    description:
      "در این بازی شما می توانید اطلاعات خود را با پاسخ دادن به سوالات، بالا ببرید",
  },
];

const sponsors = [
  {
    name: "radio Achomestan",
    url: "/images/sponsor-1.webp",
  },
  {
    name: "sponsor 2",
    url: "/images/sponsor-2.webp",
  },
  {
    name: "sponsor 3",
    url: "/images/sponsor-3.webp",
  },
];
</script>
