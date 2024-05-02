<template>
  <div
    class="flash-message bg-red-500"
    v-show="flashMessage && showMessage"
    @click="showMessage = !showMessage"
  >
    {{ flashMessage }}
  </div>
</template>
<script setup>
import { computed, ref } from "vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const flashMessage = computed(() => {
  return page.props.flash.success;
});

const showMessage = ref(true);

const remover = () => {
  showMessage.value = true;
  setTimeout(() => {
    showMessage.value = false;
  }, 2000);
};

defineExpose({
  remover,
});
</script>
