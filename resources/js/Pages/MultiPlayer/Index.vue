<template>
  <Head title="بازی دو نفره" />
  <AuthWithoutSidebarLayout>
    <template #content>
      <Box class="p-6">
        <BoxWithTitle>
          <!-- Title -->
          <template #title> بازی های فعال </template>

          <!-- Active games -->
          <div class="overflow-auto w-full">
            <table
              class="min-w-[430px] w-full text-center border-collapse bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% table-fixed"
              v-if="activeGames.length > 0"
            >
              <thead>
                <tr>
                  <th class="py-3">ردیف</th>
                  <th>امتیاز شما</th>
                  <th>امتیاز حریف</th>
                  <th>بازی</th>
                </tr>
              </thead>

              <tbody>
                <tr v-for="(game, index) in activeGames" :key="index">
                  <td class="py-5">{{ index + 1 }}</td>
                  <td>
                    {{
                      game.starter.id == user.id
                        ? game.s_corrects
                        : game.r_corrects
                    }}
                  </td>
                  <td>
                    {{
                      game.starter.id != user.id
                        ? game.s_corrects
                        : game.r_corrects
                    }}
                  </td>
                  <td>
                    <Link
                      :href="route('multi-player.play', game.id)"
                      class="btn-primary"
                    >
                      بازی
                    </Link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Game details -->
          <div class="flex gap-4 items-center">
            <p>تعداد بازی فعال: 1</p>
            <button class="btn-primary">افزایش تعداد: 1000 سکه</button>
          </div>
        </BoxWithTitle>
      </Box>
      <Box class="p-6 mt-4">
        <BoxWithTitle>
          <!-- Title -->
          <template #title>آخرین بازی ها</template>

          <div class="overflow-auto w-full">
            <table
              class="min-w-[430px] w-full text-center border-collapse bg-gradient-to-r from-indigo-500 from-10% via-sky-500 via-30% to-emerald-500 to-90% table-fixed"
              v-if="games.length > 0"
            >
              <thead>
                <tr>
                  <th class="py-3">ردیف</th>
                  <th>امتیاز شما</th>
                  <th>امتیاز حریف</th>
                  <th>وضعیت</th>
                  <th>مشاهده</th>
                </tr>
              </thead>

              <tbody>
                <tr v-for="(game, index) in games" :key="index">
                  <td class="py-5">{{ index + 1 }}</td>
                  <td>
                    {{
                      game.starter.id == user.id
                        ? game.s_corrects
                        : game.r_corrects
                    }}
                  </td>
                  <td>
                    {{
                      game.starter.id != user.id
                        ? game.s_corrects
                        : game.r_corrects
                    }}
                  </td>
                  <td class="text-white font-bold">
                    {{ determinWinner(game) }}
                  </td>
                  <td class="text-white font-bold underline">
                    <Link :href="route('multi-player.play', game.id)"
                      >مشاهده</Link
                    >
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </BoxWithTitle>
      </Box>
      <Box class="p-6 mt-4">
        <BoxWithTitle>
          <!-- Title -->
          <template #title>ایجاد بازی جدید</template>
          <!-- Errors -->
          <div
            class="w-1/2 mx-auto p-4 bg-red-500 mb-4 text-white text-center"
            v-show="errors.message"
          >
            {{ errors.message }}
          </div>
          <!-- Create games -->
          <div class="flex gap-8 flex-wrap justify-center">
            <!-- Normal -->
            <div
              class="bg-gradient-to-tr from-gray-500 from-10% to-black to-80% flex flex-col gap-2 pt-5 px-5 pb-5 text-white w-56"
            >
              <p class="text-center font-bold text-lg">{{ normal.name }}</p>
              <p class="mt-5">
                <font-awesome-icon :icon="['fas', 'coins']" /><span class="mr-2"
                  >هزینه: {{ normal.cost }} سکه</span
                >
              </p>
              <p>
                <font-awesome-icon :icon="['fas', 'gift']" /><span class="mr-2"
                  >جایزه: {{ normal.coin }} سکه</span
                >
              </p>
              <p>
                <font-awesome-icon :icon="['fas', 'hand-holding-heart']" /><span
                  class="mr-2"
                  >جایزه: {{ normal.point }} امتیاز</span
                >
              </p>
              <p class="text-white font-bold mt-5 text-center">
                حداقل سطح: {{ normal.required_level.name }}
              </p>
              <p class="text-center">
                <Link
                  as="button"
                  method="post"
                  :href="route('multi-player.create', normal.id)"
                  ><button class="btn-primary">شروع بازی</button></Link
                >
              </p>
            </div>

            <!-- Bronez -->
            <!-- background: linear-gradient(to bottom, #CD7F32 0%, #BE7023 100%); -->
            <div
              class="bg-gradient-to-b from-[#CD7F32] to-[#BE7023] flex flex-col gap-2 pt-5 px-5 pb-5 text-white w-56"
            >
              <p class="text-center font-bold text-lg">{{ bronze.name }}</p>
              <p class="mt-5">
                <font-awesome-icon :icon="['fas', 'coins']" /><span class="mr-2"
                  >هزینه: {{ bronze.cost }} سکه</span
                >
              </p>
              <p>
                <font-awesome-icon :icon="['fas', 'gift']" /><span class="mr-2"
                  >جایزه: {{ bronze.coin }} سکه</span
                >
              </p>
              <p>
                <font-awesome-icon :icon="['fas', 'hand-holding-heart']" /><span
                  class="mr-2"
                  >جایزه: {{ bronze.point }} امتیاز</span
                >
              </p>
              <p class="text-white font-bold mt-5 text-center">
                حداقل سطح: {{ bronze.required_level.name }}
              </p>
              <p class="text-center">
                <Link
                  as="button"
                  method="post"
                  :href="route('multi-player.create', bronze.id)"
                  ><button class="btn-primary">شروع بازی</button></Link
                >
              </p>
            </div>

            <!-- Silver -->
            <!-- background: linear-gradient(to bottom, #CD7F32 0%, #BE7023 100%); -->
            <div
              class="bg-gradient-to-b from-[#ededed] to-[#bdbdbd] flex flex-col gap-2 pt-5 px-5 pb-5 text-black w-56"
            >
              <p class="text-center font-bold text-lg">{{ silver.name }}</p>
              <p class="mt-5">
                <font-awesome-icon :icon="['fas', 'coins']" /><span class="mr-2"
                  >هزینه: {{ silver.cost }} سکه</span
                >
              </p>
              <p>
                <font-awesome-icon :icon="['fas', 'gift']" /><span class="mr-2"
                  >جایزه: {{ silver.coin }} سکه</span
                >
              </p>
              <p>
                <font-awesome-icon :icon="['fas', 'hand-holding-heart']" /><span
                  class="mr-2"
                  >جایزه: {{ silver.point }} امتیاز</span
                >
              </p>
              <p class="font-bold mt-5 text-center">
                حداقل سطح: {{ silver.required_level.name }}
              </p>
              <p class="text-center">
                <Link
                  as="button"
                  method="post"
                  :href="route('multi-player.create', silver.id)"
                  ><button class="btn-primary">شروع بازی</button></Link
                >
              </p>
            </div>

            <!-- Gold -->
            <!-- background: linear-gradient(to bottom, #CD7F32 0%, #BE7023 100%); -->
            <div
              class="bg-gradient-to-t from-[#7D3E00] to-[#FFC170] flex flex-col gap-2 pt-5 px-5 pb-5 text-black w-56"
            >
              <p class="text-center font-bold text-lg">{{ gold.name }}</p>
              <p class="mt-5">
                <font-awesome-icon :icon="['fas', 'coins']" /><span class="mr-2"
                  >هزینه: {{ gold.cost }} سکه</span
                >
              </p>
              <p>
                <font-awesome-icon :icon="['fas', 'gift']" /><span class="mr-2"
                  >جایزه: {{ gold.coin }} سکه</span
                >
              </p>
              <p>
                <font-awesome-icon
                  class="text-yellow-500 border-1 border-white"
                  :icon="['fas', 'star']"
                /><span class="mr-2">جایزه: {{ gold.star }} ستاره</span>
              </p>
              <p class="font-bold mt-5 text-center text-white">
                حداقل سطح: {{ gold.required_level.name }}
              </p>
              <p class="text-center">
                <Link
                  as="button"
                  method="post"
                  :href="route('multi-player.create', gold.id)"
                  ><button class="btn-primary">شروع بازی</button></Link
                >
              </p>
            </div>
          </div>
        </BoxWithTitle>
      </Box>
    </template>
  </AuthWithoutSidebarLayout>
</template>

<script setup>
import Box from "@/Components/Box.vue";
import BoxWithTitle from "@/Components/BoxWithTitle.vue";
import AuthWithoutSidebarLayout from "@/Layouts/AuthWithoutSidebarLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
  games: Object,
  user: Object,
  activeGames: Object,
  normal: Object,
  bronze: Object,
  silver: Object,
  gold: Object,
});

const page = usePage();
const errors = computed(() => page.props.errors);

const determinWinner = (game) => {
  if (game.starter.id == props.user.id) {
    if (Number(game.s_corrects) > Number(game.r_corrects)) {
      return "برنده";
    } else if (Number(game.s_corrects) < Number(game.r_corrects)) {
      return "بازنده";
    } else if (Number(game.s_corrects) == Number(game.r_corrects)) {
      return "مساوی";
    }
  } else if (game.rival.id == props.user.id) {
    if (Number(game.r_corrects) > Number(game.s_corrects)) {
      return "برنده";
    } else if (Number(game.r_corrects) < Number(game.s_corrects)) {
      return "بازنده";
    } else if (Number(game.s_corrects) == Number(game.r_corrects)) {
      return "مساوی";
    }
  }
};
</script>
