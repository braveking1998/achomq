<template>
  <div>
    <h1 class="font-bold text-gray-600 text-lg mb-8">
      <slot name="title" />
    </h1>
    <div class="flex flex-col gap-4 mx-4 sm:mx-8 lg:mx-16">
      <slot>Default</slot>
    </div>
  </div>
</template>
