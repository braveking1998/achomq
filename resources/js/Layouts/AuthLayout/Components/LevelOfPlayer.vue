<template>
  <div>
    <div class="min-w-[100px] min-h-[100px]">
      <div
        class="bg-white w-20 h-20 rounded-full absolute mt-3 mr-3 border-2 border-[#E8E3E3] z-50"
      ></div>
      <svg
        class="relative -rotate-90 max-w-[100px] w-full z-50"
        data-percentage="19"
        viewBox="0 0 80 80"
      >
        <circle
          class="fill-[rgba(0,0,0,0)] stroke-dashoffset stroke-[10] stroke-transparent"
          cx="40"
          cy="40"
          r="35"
        ></circle>
        <!-- The number to deal with percentage is  219.91148575129
                    Frist deviden the the progress by the level optimal percentage,
                    Then multiply it with the number,
                    At last substract the reminder from the numebr -->
        <circle
          class="fill-[rgba(0,0,0,0)] stroke-[#ABD6DF] stroke-dashoffset stroke-[10] stroke-dasharray"
          cx="40"
          cy="40"
          r="35"
          :style="{
            strokeDashoffset:
              219.91148575129 -
              (auth.user.points * 219.91148575129) / auth.user.level.max,
          }"
        ></circle>
        <text
          class="fill-[#ABD6DF] text-anchor-middle font-bold text-xl"
          x="50%"
          y="57%"
          transform="matrix(0, 1, -1, 0, 80, 0)"
        >
          {{ Math.floor((auth.user.points / auth.user.level.max) * 100) }}%
        </text>
      </svg>
    </div>
    <div
      class="-mr-10 bg-gray-300 border-b-2 border-green-400 text-center p-4 pr-16 pl-10 font-bold text-lg text-green-700"
    >
      {{ auth.user.level.name }}
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const auth = computed(() => page.props.auth);
</script>
