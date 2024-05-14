<template>
  <guest-layout>
    <Head title="Reset Password" />

    <form @submit.prevent="submit">
      <div>
        <input-label for="email" value="Email" />

        <text-input
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="form.email"
          required
          autofocus
          autocomplete="username"
        />

        <input-error class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <input-label for="password" value="Password" />

        <text-input
          id="password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password"
          required
          autocomplete="new-password"
        />

        <input-error class="mt-2" :message="form.errors.password" />
      </div>

      <div class="mt-4">
        <input-label for="password_confirmation" value="Confirm Password" />

        <text-input
          id="password_confirmation"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password_confirmation"
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
          Reset Password
        </primary-button>
      </div>
    </form>
  </guest-layout>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";

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
