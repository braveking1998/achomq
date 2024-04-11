<template>
    <Head :title="title" />
    <GuestLayout :title="title">
        Contact us
    </GuestLayout>
</template>
<script setup>
    import { Head } from '@inertiajs/vue3';
    import GuestLayout from '@/Layouts/GuestLayout.vue';

    const title = 'تماس با ما';
</script>