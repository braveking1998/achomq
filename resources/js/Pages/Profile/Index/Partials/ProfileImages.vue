<template>
  <!-- Upload public profile images -->
  <BoxWithTitle>
    <!-- Title -->
    <template #title>انتخاب عکس پروفایل</template>

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
              :href="route('profile.images.destroy', image.id)"
              as="button"
              method="delete"
              class="bg-red-500 text-white px-3 py-1 rounded-full absolute -right-2 -top-2 hover:opacity-80"
              v-if="image.type === 'private'"
            >
              x
            </Link>
            <img
              :src="image.src"
              :alt="image.type"
              class="w-full h-full hover:opacity-60 hover:cursor-pointer hover:border-green-500 hover:border-4"
              :class="{
                'opacity-60 border-4 border-green-500':
                  image.id === selectedImage.id,
              }"
              @click="selectNewImage(image.id)"
            />
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
</template>

<script setup>
import BoxWithTitle from "@/Components/BoxWithTitle.vue";
import { usePage, Link, router } from "@inertiajs/vue3";
import { computed } from "vue";

defineProps({
  images: Object,
});

const page = usePage();
const selectedImage = computed(() => page.props.auth.selectedImage);
const errors = computed(() => Object.values(page.props.errors));

const chooseFile = (event) => {
  let file = event.target.files[0];

  console.log(file);

  router.post(
    route("profile.images.store"),
    {
      image: file,
      type: "private",
    },
    {
      onSuccess: () => {
        flashMessageVisible.value = true;
        flashMessageVisibleChange(2000);
      },
    }
  );
};

const selectNewImage = (id) => {
  router.put(route("profile.update.image", { image_id: id }));
};
</script>
