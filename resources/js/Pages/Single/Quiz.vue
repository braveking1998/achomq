<template>
  <Head title="بازی تک نفره" />
  <auth-without-sidebar-layout>
    <template #content>
      <app-box
        class="container md:max-w-[50%] mx-auto relative"
        v-for="(question, index) in questions"
        :key="index"
        v-show="index == totalAnswered"
      >
        <!-- Question -->
        <!-- Header -->
        <div
          class="absolute top-0 right-0 h-10 z-10"
          :class="`bg-${color}`"
          :style="`width: ${((totalAnswered + 1) / questions.length) * 100}%`"
        ></div>
        <!-- timer -->
        <div
          class="text-center text-white bg-opacity-40 font-bold shadow-sm h-10 leading-10 relative z-20"
          :class="`bg-${color}`"
        >
          <p class="absolute z-20 right-0 left-0 mx-auto text-white">
            سوال {{ index + 1 }} از {{ questions.length }}
          </p>
          <p class="absolute left-5 text-white">{{ timer }}</p>
        </div>
        <!-- Question text -->
        <div class="my-8 font-bold text-center" :class="`text-${color}`">
          {{ question.text }}
        </div>
        <ul class="m-4 px-4">
          <!-- Answer -->
          <div v-if="answered === null" class="flex flex-col gap-4 text-center">
            <li
              v-for="answer in question.answers"
              :key="answer.unique_id"
              @click="answerClicked(answer.unique_id, answer.is_correct)"
              class="text-center w-full hover:bg-opacity-100 bg-opacity-20 py-2 font-bold hover:text-white cursor-pointer"
              :class="`hover:bg-${color} bg-${color} text-${color}`"
            >
              {{ answer.text }}
            </li>
          </div>

          <!-- Correct answer -->
          <div v-else class="flex flex-col gap-4">
            <li
              v-for="answer in question.answers"
              :key="answer.unique_id"
              :class="[
                'py-2 font-bold text-white grid grid-cols-12 text-center',
                answer.is_correct == 1 && answer.unique_id
                  ? 'bg-green-500'
                  : 'bg-red-500 opacity-50',
                { '!opacity-100': answered === answer.unique_id },
              ]"
            >
              <div class="col-span-8">{{ answer.text }}</div>
              <div v-if="answer.is_correct == true" class="col-span-4">
                درست
              </div>
              <div v-else class="col-span-4">اشتباه</div>
            </li>
          </div>
        </ul>
        <transition name="fade">
          <button
            class="btn-primary border-2 block mr-auto ml-4 my-8 font-bold"
            :class="`bg-${color} hover:border-${color} hover:text-${color}`"
            v-show="answered"
            @click="next"
          >
            بعدی
          </button>
        </transition>
      </app-box>
    </template>
  </auth-without-sidebar-layout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import AppBox from "@/Components/AppBox.vue";
import { router } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const props = defineProps({
  questions: Object,
  color: String,
  time: Number,
});

const timer = ref(props.time);
const timerEnabled = ref(true);
const totalAnswered = ref(0);
const correctAnswers = ref(0);
const answered = ref(null);

const answerClicked = (id, is_correct) => {
  if (answered.value == null) {
    answered.value = id;
    timerEnabled.value = false;
  }

  if (Number(is_correct)) {
    correctAnswers.value++;
  }
};

const next = () => {
  if (totalAnswered.value < props.questions.length - 1) {
    answered.value = null;
    timer.value = props.time;
    timerEnabled.value = true;
    totalAnswered.value++;
  } else {
    router.put("", {
      total: props.questions.length,
      correct: correctAnswers.value,
      color: props.color,
    });
  }
};

watch(
  timer,
  (value) => {
    if (value && timerEnabled.value) {
      setTimeout(() => {
        timer.value--;
      }, 1000);
    } else {
      if (answered.value == null) {
        answered.value = 1;
      }
    }
  },
  { immediate: true }
);
</script>

<style>
.fade-enter-active {
  transition: opacity 0.2s ease;
}

.fade-leave-active {
  transition: opacity 0s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
