<template>
    <div class="flex md:gap-1 items-center [&>*:first-child>span]:w-[80px] [&>*:first-child>span]:block [&>*:last-child>span]:w-[80px] [&>*:last-child>span]:block">
      <div v-for="(link, index) in links">
        <span v-if="link.url === null" class="py-2 px-4 rounded-md" v-html="link.label" :key="link.label"></span>
        <span v-else>
          <Link
          v-show="index < 3 || link.label == links[links.length - 1].label || link.label == links[links.length - 2].label"
          :key="index" class="py-2 px-4 rounded-md md:hidden" 
          :href="link.url" 
          :class="{'bg-indigo-500 dark:bg-indigo-800 text-gray-300': link.active}"
          v-html="link.label"
          />
          <Link
          :key="index" class="py-2 px-4 rounded-md hidden md:inline" 
          :href="link.url" 
          :class="{'bg-indigo-500 dark:bg-indigo-800 text-gray-300': link.active}"
          v-html="link.label"
          />
        </span>
      </div>
    </div>
  </template>
  
  <script setup>
  import {Link} from '@inertiajs/vue3'
  defineProps({links: Array})
  </script>