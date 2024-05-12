<template>
  <Head title="Register" />
  <guest-layout>
    <app-box class="w-4/5 md:w-1/2 mx-auto my-10 p-6">
      <form @submit.prevent="submit">
        <div>
          <input-label for="name" value="نام" />

          <text-input
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
            required
            autofocus
            autocomplete="name"
          />

          <input-error class="mt-2" :message="form.errors.name" />
        </div>

        <div class="mt-4">
          <input-label for="email" value="ایمیل" />

          <text-input
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
            autocomplete="username"
            dir="ltr"
          />

          <input-error class="mt-2" :message="form.errors.email" />
        </div>

        <div class="mt-4">
          <input-label for="phone-number" value="شماره همراه" />

          <text-input
            id="phone-number"
            type="text"
            class="mt-1 block w-full"
            v-model="form.phoneNumber"
            required
            dir="ltr"
          />

          <input-error class="mt-2" :message="form.errors.phoneNumber" />
        </div>

        <div class="mt-4">
          <input-label for="password" value="رمزعبور" />

          <text-input
            id="password"
            type="password"
            class="mt-1 block w-full"
            v-model="form.password"
            required
            autocomplete="new-password"
            dir="ltr"
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
            required
            autocomplete="new-password"
            dir="ltr"
          />

          <input-error
            class="mt-2"
            :message="form.errors.password_confirmation"
          />
        </div>

        <div
          class="flex flex-col sm:flex-row gap-4 sm:gap-0 items-center justify-end mt-4"
        >
          <Link
            :href="route('login')"
            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          >
            آیا می خواهید وارد شوید؟
          </Link>

          <primary-button
            class="ms-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            ثبت نام
          </primary-button>
        </div>
      </form>
    </app-box>
  </guest-layout>
</template>

<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import AppBox from "@/Components/AppBox.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const title = "عضویت";

const form = useForm({
  name: "",
  email: "",
  phoneNumber: "",
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>
