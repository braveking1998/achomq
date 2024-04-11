<template>
    <Link :href="route(href)" class="btn-link" :class="{'bg-blue-light text-white' : route().current(href)}"> 
        <slot />
    </Link>
</template>
<script setup>
    import { Link } from '@inertiajs/vue3';

    defineProps({
        href: {
            type: String,
            required: true
        }
    });
</script>