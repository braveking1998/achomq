<template>
  <Head :title="title" />
  <guest-layout :title="title">
    <app-box class="w-4/5 md:w-1/2 mx-auto my-10 p-6">
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
            dir="ltr"
            v-model="form.email"
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
            autocomplete="current-password"
          />

          <input-error class="mt-2" :message="form.errors.password" />
        </div>

        <div class="block mt-4">
          <label class="flex items-center">
            <checkbox name="remember" v-model:checked="form.remember" />
            <span class="ms-2 text-sm text-gray-600">مرا به خاطر بسپار</span>
          </label>
        </div>

        <div class="flex items-center justify-end mt-4">
          <Link
            v-if="canResetPassword"
            :href="route('password.request')"
            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            آیا رمز خود را فراموش کرده اید؟
          </Link>

          <primary-button
            class="ms-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            ورود
          </primary-button>
        </div>
      </form>
    </app-box>
  </guest-layout>
</template>

<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import AppBox from "@/Components/AppBox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const title = "ورود";

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>
