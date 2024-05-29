<template>
  <Head title="بازیابی رمزعبور" />
  <guest-layout>
    <app-box class="w-4/5 md:w-1/2 mx-auto my-10 p-6">
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

        <div class="mt-4">
          <input-label for="password" value="رمزعبور" />

          <text-input
            id="password"
            type="password"
            class="mt-1 block w-full"
            dir="ltr"
            v-model="form.password"
            required
            autocomplete="new-password"
          />

          <input-error class="mt-2" :message="form.errors.password" />
        </div>

        <div class="mt-4">
          <input-label for="password_confirmation" value="تکرار رمزعبور" />

          <text-input
            id="password_confirmation"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password_confirmation"
            dir="ltr"
            required
            autocomplete="new-password"
          />

          <input-error
            class="mt-2"
            :message="form.errors.password_confirmation"
          />
        </div>

        <div class="flex items-center justify-end mt-4">
          <primary-button
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            تغییر رمز عبور
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

const props = defineProps({
  email: {
    type: String,
    required: true,
  },
  token: {
    type: String,
    required: true,
  },
});

const form = useForm({
  token: props.token,
  email: props.email,
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("password.store"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>
