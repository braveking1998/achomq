<template>
  <!-- Header -->
  <header>
    <div class="py-6 sm:py-2 sm:pr-4 text-gray-900">
      <app-dropdown :title="title">
        <dropdown-link href="guest.front">صفحه نخست</dropdown-link>
        <dropdown-link href="guest.about">درباره ما</dropdown-link>
        <dropdown-link href="guest.contact">تماس با ما</dropdown-link>
      </app-dropdown>
    </div>

    <!-- Slider -->
    <section
      class="bg-[url('/images/header-bg.webp')] bg-no-repeat bg-left-bottom bg-cover h-[550px] sm:h-fit p-10 sm:px-0 md:py-20"
    >
      <div
        class="flex flex-col-reverse sm:flex-row justify-center content-center gap-12 lg:justify-evenly"
      >
        <div class="text-center text-white leading-loose lg:text-2xl">
          <h1 class="font-bold text-xl mb-2 sm:mb-4 lg:text-4xl">اچم کیو</h1>
          <div class="lg:mt-8">
            اطلاعات خود را محک بزنید و همه جایزه ها را درو کنید
          </div>
          <div class="hidden sm:block lg:mt-8">به همین سادگی!!!</div>
          <div class="hidden sm:block lg:mt-8">
            پس منتظر چی هستی؟ همین حال شروع کن
          </div>
        </div>
        <div
          class="max-h-[200px] max-w-[240px] m-auto sm:m-0 sm:w-1/4 lg:w-1/3 sm:max-h-none sm:max-w-none"
        >
          <img src="/images/logo.webp" />
        </div>
      </div>
      <div
        class="mt-8 flex flex-col sm:flex-row gap-4 items-center sm:justify-end ml-4 lg:mt-16"
      >
        <Link :href="route('login')" class="btn-sign w-[230px]"
          >از اینجا وارد شو</Link
        >
        <Link
          :href="route('register')"
          class="btn-sign bg-blue-primary w-[230px]"
          >همین الان شروع کن</Link
        >
      </div>
    </section>
  </header>

  <!-- Main -->
  <main>
    <slot />
  </main>

  <!-- Footer -->
  <footer
    class="bg-[url('/images/footer-bg.webp')] bg-no-repeat bg-left-top bg-cover h-[450px] md:h-[350px] text-gray-200 text-lg pt-10"
  >
    <div
      class="flex flex-col md:flex-row justify-center items-center gap-8 md:gap-16 my-4 md:my-14"
    >
      <div>
        <div class="mt-10 md:mt-0">سوالی از اچم کیو دارید</div>
        <div class="mt-8 md:mt-16 flex justify-center items-center gap-4">
          <a href="#" target="_blank" rel="noopener noreferrer"
            ><font-awesome-icon icon="fa-brands fa-instagram" size="2xl"
          /></a>
          <a href="#" target="_blank" rel="noopener noreferrer"
            ><font-awesome-icon icon="fa-brands fa-square-facebook" size="2xl"
          /></a>
        </div>
      </div>
      <div class="flex flex-col justify-center items-center">
        <div>
          <div>در صورت هر گونه پیشنهاد به شماره زیر ارسال کنید</div>
          <ul class="flex gap-4 justify-center mt-4">
            <li>09391613713</li>
            <li>07152623008</li>
          </ul>
        </div>
        <div class="mt-6">
          <app-search />
        </div>
      </div>
    </div>
    <div class="text-center mt-10">
      تمامی حقوق وبسایت متعلق به اچم کیو می باشد.
    </div>
  </footer>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import AppSearch from "@/Layouts/GuestLayout/Components/AppSearch.vue";
import AppDropdown from "@/Components/AppDropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

defineProps({ title: String });
</script>
