<template>
  <Head title="داشبورد" />
  <auth-without-sidebar-layout>
    <template #content>
      <!-- Heart -->
      <app-box class="p-6">
        <div class="text-center">
          تعداد قلب های شما برای شرکت در مسابقه تک نفره:
          <span>{{ auth.user.hearts }}&nbsp;</span>
          <font-awesome-icon :icon="['fas', 'heart']" class="text-red-600" />
          <span>&nbsp;(هر یک دقیقه به شما یک قلب داده می شود.)</span>
        </div>
      </app-box>

      <!-- Matches -->
      <div
        class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-16 justify-center items-center mt-8 px-10"
      >
        <Link :href="route('single.index')" class="btn-primary-border"
          >مسابقه تک نفره</Link
        >
        <Link :href="route('multi.index')" class="btn-danger-border"
          >مسابقه دو نفره</Link
        >
        <button class="btn-success-disabled" disabled>
          مسابقه گروهی (بزودی)
        </button>
      </div>

      <!-- Events -->
      <app-event />
    </template>
  </auth-without-sidebar-layout>
</template>

<script setup>
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import AppBox from "@/Components/AppBox.vue";
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import AppEvent from "@/Pages/Dashboard/Components/AppEvent.vue";

const page = usePage();
const auth = computed(() => page.props.auth);
</script>
