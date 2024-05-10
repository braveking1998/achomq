<template>
  <div>
    <!-- Prev -->
    <div>
      <button
        @click="decrease()"
        class="block border-4 border-gray-200 rounded-full p-4 text-gray-600"
        :class="{ 'opacity-20': x == 0 }"
      >
        <font-awesome-icon :icon="['fas', 'arrow-right']" size="2xl" />
      </button>
    </div>

    <slot :x="x">default</slot>

    <!-- Next -->
    <div>
      <button
        @click="increase()"
        class="block border-4 border-gray-200 rounded-full p-4 text-gray-600"
        :class="{ 'opacity-20': x === data.length - 1 }"
      >
        <font-awesome-icon :icon="['fas', 'arrow-left']" size="2xl" />
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
  data: Array,
});

const x = ref(0);

const increase = () => {
  if (x.value !== props.data.length - 1) {
    x.value += 1;
  }
};

const decrease = () => {
  if (x.value != 0) {
    x.value -= 1;
  }
};
</script>
