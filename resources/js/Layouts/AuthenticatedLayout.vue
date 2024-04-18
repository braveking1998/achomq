<template>
  <div class="flex flex-col min-h-[100vh]">
    <header>
      <div class="py-6 border-b-4 border-gray-600">
        <HeaderSmallDevices class="block md:hidden" />
        <HeaderLargeDevices
          class="hidden md:flex md:justify-around md:items-center"
        />
      </div>
    </header>
    <main class="bg-gray-100 grow">
      <slot />
    </main>
    <footer class="py-8 bg-slate-800 px-12">
      <div class="flex flex-col gap-4 sm:flex-row justify-around items-center">
        <Link
          :href="route('questions.index')"
          class="btn-primary bg-slate-500 text-slate-800 rounded-none hover:bg-slate-800 border border-slate-500 hover:border-slate-500 font-bold hover:text-slate-500"
          >کل موضوعات سوالات</Link
        >
        <Link
          :href="route('dashboard')"
          class="btn-primary bg-slate-500 text-slate-800 rounded-none hover:bg-slate-800 border border-slate-500 hover:border-slate-500 font-bold hover:text-slate-500"
          >پشتیبانی اچم کیو</Link
        >
        <Link
          :href="route('dashboard')"
          class="btn-primary bg-slate-500 text-slate-800 rounded-none hover:bg-slate-800 border border-slate-500 hover:border-slate-500 font-bold hover:text-slate-500"
          >راهنمای بازی</Link
        >
        <div class="flex gap-8">
          <Link href="#" target="_blank" rel="noopener noreferrer"
            ><font-awesome-icon
              icon="fa-brands fa-instagram"
              class="text-white hover:text-slate-500"
              size="2xl"
          /></Link>
          <Link href="#" target="_blank" rel="noopener noreferrer"
            ><font-awesome-icon
              icon="fa-brands fa-square-facebook"
              class="text-white hover:text-slate-500"
              size="2xl"
          /></Link>
        </div>
      </div>
      <div class="mt-12 text-center font-bold text-white">
        تمامی حقوق اچم کیو محفوظ است. ©️
      </div>
    </footer>
  </div>
</template>

<script setup>
import HeaderSmallDevices from "@/Layouts/AuthLayout/Components/HeaderSmallDevices.vue";
import HeaderLargeDevices from "@/Layouts/AuthLayout/Components/HeaderLargeDevices.vue";
import { Link } from "@inertiajs/vue3";
</script>
