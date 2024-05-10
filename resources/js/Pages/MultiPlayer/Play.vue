<template>
  <Head title="بازی دو نفره" />
  <AuthWithoutSidebarLayout>
    <template #header>
      <Breadcrumbs :breadcrumbs="breadcrumbs"> </Breadcrumbs>
    </template>
    <template #content>
      <div class="w-full md:w-2/3 mx-auto">
        <div class="grid grid-cols-2">
          <!-- Starter -->
          <div class="flex flex-col border-l-2 border-gray-500">
            <!-- Titles -->
            <DisplayUser
              :src="game.starter.chosen_image.src"
              :name="game.starter.name"
            />

            <!-- Starter Answers loop -->
            <div v-for="game in s_answers">
              <DisplayButtons :answers="game" />
            </div>
          </div>

          <!-- Rival -->
          <div class="flex flex-col">
            <!-- Titles -->
            <DisplayUser
              :src="game.rival.chosen_image.src"
              :name="game.rival.name"
            />

            <!-- Rival Answers loop -->
            <div v-for="game in r_answers">
              <DisplayButtons :answers="game" />
            </div>
          </div>
          <div v-if="s_answers.length === 0" class="w-full col-span-2 mt-4">
            <p class="text-center">شما باید بازی را شروع کنید.</p>
          </div>

          <!-- Button -->
          <div class="col-span-2 mt-8">
            <StartButton
              :text="whoToPlay()"
              :game="game"
              v-if="game.is_active == 1"
            />
            <button
              v-else
              class="btn-primary block mx-auto hover:bg-blue-light hover:text-white hover:border-white focus:border-white cursor-default"
            >
              {{ determinWinner(game) }}
            </button>
          </div>
        </div>
      </div>
    </template>
  </AuthWithoutSidebarLayout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import DisplayButtons from "@/Pages/MultiPlayer/Index/Partials/DisplayButtons.vue";
import StartButton from "@/Pages/MultiPlayer/Index/Partials/StartButton.vue";
import DisplayUser from "@/Pages/MultiPlayer/Index/Partials/DisplayUser.vue";
import { ref } from "vue";
import { onMounted, onUnmounted } from "vue";
import { preventGoBack, allowGoBack } from "@/Composables/preventer";
import Breadcrumbs from "@/Components/Breadcrumbs.vue";

// breadcrumbs
const breadcrumbs = [
  { label: "داشبورد", url: route("dashboard") },
  { label: "بازی های دو نفره", url: route("multi-player.index") },
];

onMounted(() => {
  preventGoBack();
});

onUnmounted(() => {
  allowGoBack();
});

const props = defineProps({
  game: Object,
  gamerType: String,
  user: Object,
});

const whoToPlay = () => {
  if (props.user.id == props.game.who_to_play) {
    return "user";
  }

  return "rival";
};

// Starter: stages
const s_answers = ref([]);

if (props.game.s_answers) {
  s_answers.value = JSON.parse(props.game.s_answers);
}

// Rival: stages
const r_answers = ref([]);

if (props.game.r_answers) {
  r_answers.value = JSON.parse(props.game.r_answers);
}

const determinWinner = (game) => {
  if (game.starter.id == props.user.id) {
    if (Number(game.s_corrects) > Number(game.r_corrects)) {
      return "شما برنده شدید !";
    } else if (Number(game.s_corrects) < Number(game.r_corrects)) {
      return "شما بازنده شدید !";
    } else if (Number(game.s_corrects) == Number(game.r_corrects)) {
      return "بازی مساوی شد !";
    }
  } else if (game.rival.id == props.user.id) {
    if (Number(game.r_corrects) > Number(game.s_corrects)) {
      return "شما برنده شدید !";
    } else if (Number(game.r_corrects) < Number(game.s_corrects)) {
      return "شما بازنده شدید !";
    } else if (Number(game.s_corrects) == Number(game.r_corrects)) {
      return "بازی مساوی شد !";
    }
  }
};
</script>
