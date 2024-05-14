<template>
  <Head :title="title" />
  <guest-layout :title="title"> About us </guest-layout>
</template>
<script setup>
import { Head } from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";

const title = "درباره ما";
</script>
