<template>
  <Head title="آپلود تصاویر عمومی" />

  <GameSetting tab="images">
    <!-- Flash messages -->
    <FlashMessage ref="messageComponent" />

    <!-- Upload public profile images -->
    <BoxWithTitle>
      <!-- Title -->
      <template #title
        >آپلود تصاویر عمومی پروفایل (اندازه استاندارد 512 × 512 پیکسل)</template
      >

      <!-- Content -->
      <template #default>
        <!-- Content -->
        <div class="flex flex-col gap-4">
          <!-- Errors -->
          <div v-if="errors.length">
            <div
              v-for="(error, index) in errors"
              :key="index"
              class="input-error"
            >
              {{ error }}
            </div>
          </div>

          <!-- Upload via system -->
          <div class="flex gap-12 flex-wrap">
            <!-- Uploaded files -->
            <div
              class="w-24 h-24 relative"
              v-for="image in images"
              :key="image.id"
            >
              <Link
                :href="route('admin.setting.images.destroy', image.id)"
                as="button"
                method="delete"
                class="bg-red-500 text-white px-3 py-1 rounded-full absolute -right-2 -top-2 hover:opacity-80"
                v-if="image.id != 1"
              >
                x
              </Link>
              <img :src="image.src" :alt="image.type" class="w-full h-full" />
            </div>

            <!-- Uploader -->
            <div
              class="w-24 h-24 bg-gray-200 text-gray-700 hover:cursor-pointer hover:bg-gray-400 text-center leading-[6rem]"
              @click="$refs.chooseFile.click()"
            >
              آپلود عکس
            </div>
            <input
              type="file"
              ref="chooseFile"
              @change="chooseFile"
              class="hidden"
            />
          </div>
        </div>
      </template>
    </BoxWithTitle>
  </GameSetting>
</template>

<script setup>
import { Head, router, usePage, Link } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import GameSetting from "@/Layouts/GameSetting.vue";
import BoxWithTitle from "@/Components/BoxWithTitle.vue";
import FlashMessage from "@/Components/FlashMessage.vue";

defineProps({
  images: Object,
});

const page = usePage();
const errors = computed(() => Object.values(page.props.errors));

// Handle flash messages
const messageComponent = ref(null);

const chooseFile = (event) => {
  let file = event.target.files[0];

  router.post(
    route("admin.setting.images.store"),
    {
      image: file,
    },
    {
      onSuccess: () => {
        messageComponent.value.remover();
      },
    }
  );
};
</script>
