<template>
  <guest-layout>
    <Head title="Confirm Password" />

    <div class="mb-4 text-sm text-gray-600">
      This is a secure area of the application. Please confirm your password
      before continuing.
    </div>

    <form @submit.prevent="submit">
      <div>
        <input-label for="password" value="Password" />
        <text-input
          id="password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password"
          required
          autocomplete="current-password"
          autofocus
        />
        <input-error class="mt-2" :message="form.errors.password" />
      </div>

      <div class="flex justify-end mt-4">
        <primary-button
          class="ms-4"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Confirm
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

const form = useForm({
  password: "",
});

const submit = () => {
  form.post(route("password.confirm"), {
    onFinish: () => form.reset(),
  });
};
</script>
