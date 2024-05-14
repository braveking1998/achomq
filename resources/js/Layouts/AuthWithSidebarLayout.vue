<template>
  <authenticated-layout>
    <div class="py-12 flex flex-col gap-8 w-[85%] mx-auto">
      <slot name="header"></slot>
      <div class="flex flex-col-reverse gap-8 md:grid md:grid-cols-12">
        <aside class="md:col-span-4 flex flex-col items-center gap-8">
          <slot name="aside"></slot>
        </aside>
        <section class="md:col-span-8">
          <slot name="content" />
        </section>
      </div>
    </div>
  </authenticated-layout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>
