<template>
    <Head title="مشاهده سوال" />
    <AuthWithoutSidebarLayout>

        <template #header>
            <Breadcrumbs :breadcrumbs="breadcrumbs">
                <template #right-side>
                    <div class="flex gap-4">
                        <Link :href="route('questions.edit', question.id)" class="btn-primary bg-green-500">ویرایش سوال</Link>
                        <Link :href="route('questions.destroy', question.id)" class="btn-primary bg-red-500" method="delete" as="button">حذف سوال</Link>
                    </div>
                </template>
            </Breadcrumbs>
        </template>

        <template #content>
            <Box class="flex flex-col gap-4 p-6">
                <p class="text-gray-500"><span>متن سوال: </span>{{ question.text }}</p>
                <p class="text-gray-500"><span>دسته بندی: </span>{{ question.category.name }}</p>
                <p class="text-gray-500"><span>سطح: </span>{{ question.level.name }}</p>
                <p class="text-gray-500"><span>تاریخ ایجاد: </span>{{ dateFormated }}</p>
                <ul class="flex flex-col gap-4">
                    <li v-for="(answer, index) in question.answers" :key="answer.id" class="text-gray-500">
                        <span>پاسخ {{ index + 1 }}: </span>{{ answer.text }}
                        <span v-if="answer.is_correct" class="pr-4">✔️</span>
                    </li>
                </ul>
            </Box>
        </template>
    </AuthWithoutSidebarLayout>
</template>

<script setup>
import AuthWithoutSidebarLayout from '@/Layouts/AuthWithoutSidebarLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import Box from '@/Components/Box.vue'
import { Head, Link } from '@inertiajs/vue3'
import { useShamsiNames, useShamsiDate } from "@/Composables/date.js"

const breadcrumbs = [
    { label: 'داشبورد', url: route('dashboard') },
    { label: 'سوالات', url: route('questions.index') }
]
const props = defineProps({
    question: Object
})

// Date
const { shamsiYear, shamsiMonthNumber, shamsiMonth, shamsiDay } = useShamsiDate(new Date(props.question.created_at))
const { shamsiDayNames } = useShamsiNames()

const day = new Date(props.question.created_at).getDay()
const dateFormated = `${shamsiDayNames[day]} ${shamsiDay} ${shamsiMonth} ماه ${shamsiYear}`
</script>