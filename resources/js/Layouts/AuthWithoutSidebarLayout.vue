<template>
    <AuthenticatedLayout>
        <div class="py-12 flex flex-col gap-8 w-[85%] mx-auto">
            <slot name="header"></slot>
            <section>
                <slot name="content" />
            </section>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>