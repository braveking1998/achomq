<template>
  <Head title="Forgot Password" />
  <guest-layout>
    <app-box class="w-4/5 md:w-1/2 mx-auto my-10 p-6">
      <div class="mb-4 text-sm text-gray-600">
        رمزت رو فراموش کردی! هیچ اشکالی نداره. فقط ایمیلت رو وارد کن، بقیه اش رو
        بسپار به ما.
      </div>

      <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
      </div>

      <form @submit.prevent="submit">
        <div>
          <input-label for="email" value="ایمیل" />

          <text-input
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            dir="ltr"
            required
            autofocus
            autocomplete="username"
          />

          <input-error class="mt-2" :message="form.errors.email" />
        </div>

        <div class="flex items-center justify-end mt-4">
          <primary-button
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            ارسال لینک بازیابی رمزعبور
          </primary-button>
        </div>
      </form>
    </app-box>
  </guest-layout>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";
import AppBox from "@/Components/AppBox.vue";

defineProps({
  status: {
    type: String,
  },
});

const form = useForm({
  email: "",
});

const submit = () => {
  form.post(route("password.email"));
};
</script>
