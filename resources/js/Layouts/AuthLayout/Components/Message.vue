<template>
    <Link :href="route(href)">
        <div class="flex items-center gap-4">
            <div class="border-2 border-gray-700 p-1 rounded-full w-16">
                <img src="/images/profile.jpg" alt="profile" class="w-full h-full rounded-full"/>
            </div> 
            <div class="font-bold text-lg text-gray-700 flex flex-col gap-2 w-32">
                <p class="text-xs ">{{ text ?? 'متن مشخص نیست' }}</p>
                <p class="text-xs text-gray-500"><span>🕛 </span>{{ time ?? 'نامشخص' }}</p>
            </div>
        </div>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    href:{
        type: String,
        required: true,
    }, 
    text: String,
    time: String
})
</script>