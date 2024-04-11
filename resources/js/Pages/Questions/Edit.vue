<template>
    <Head title="ویرایش سوال" />
    <AuthWithSidebarLayout>

        <template #header>
            <Breadcrumbs :breadcrumbs="breadcrumbs" />
        </template>
        <template #aside>
            <Box class="flex flex-col gap-4 w-full p-6">
                <h1 class="text-gray-500 text-center font-bold">مشخصات سوال</h1>
                <div class="text-gray-800 text-sm flex flex-col gap-2">
                    <div>نام طراح: {{ question.user.name }}</div>
                    <div>تاریخ امروز: {{ dateFormated }}</div>
                </div>
            </Box>
        </template>
        <template #content>
            <!-- Flash messages -->
            <div v-show="flashMessage && flashMessageVisible" @click="flashMessageVisible = !flashMessageVisible" class="flash-message">
                {{ flashMessage }}
            </div>
            <Box class="p-6">
                <form @submit.prevent="update">
                    <div class="flex flex-col gap-4 md:px-16">
                        <div class="flex justify-between">
                            <div class="w-2/5">
                                <label for="level">سطح سوال:</label>
                                <select id="level" class="input" v-model.number="form.level_id">
                                    <option v-for="level in levels" :key="level.id" :value="level.id">{{ level.name }}</option>
                                </select>
                            </div>
                            <div class="w-2/5">
                                <label for="category">دسته بندی سوال:</label>
                                <select id="category" class="input" v-model.number="form.category_id">
                                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block" for="question">متن سوال:</label>
                            <textarea id="question" placeholder="متن سوال" class="input" v-model="form.question"></textarea>
                            <div class="input-error" v-if="form.errors.question">
                                {{ form.errors.question }}
                            </div>
                        </div>
                        <div>
                            <label for="correct">پاسخ صحیح</label>
                            <input type="text" id="correct" placeholder="پاسخ صحیح" class="input" v-model="form.answers.correct">
                            <div class="input-error" v-if="form.errors[`answers.correct`]">
                                {{ form.errors[`answers.correct`] }}
                            </div>
                        </div>
                        <div>
                            <label for="answer-one">پاسخ اول</label>
                            <input type="text" id="answer-one" placeholder="پاسخ اول" class="input" v-model="form.answers.answer_one">
                            <div class="input-error" v-if="form.errors[`answers.answer_one`]">
                                {{ form.errors[`answers.answer_one`] }}
                            </div>
                        </div>
                        <div>
                            <label for="answer-two">پاسخ دوم</label>
                            <input type="text" id="answer-two" placeholder="پاسخ دوم" class="input" v-model="form.answers.answer_two">
                            <div class="input-error" v-if="form.errors[`answers.answer_two`]">
                                {{ form.errors[`answers.answer_two`] }}
                            </div>
                        </div>
                        <div>
                            <label for="answer-three">پاسخ سوم</label>
                            <input type="text" id="answer-three" placeholder="پاسخ سوم" class="input" v-model="form.answers.answer_three">
                            <div class="input-error" v-if="form.errors[`answers.answer_three`]">
                                {{ form.errors[`answers.answer_three`] }}
                            </div>
                        </div>
                        <div class="flex flex-col md:flex-row gap-4 mt-4">
                            <button type="submit" class="btn-primary">ثبت سوال</button>
                            <button type="rest" class="btn-bordered" @click.prevent="form.reset()">از نو سازی</button>
                        </div>
                    </div>
                </form>
            </Box>
        </template>
    </AuthWithSidebarLayout>
</template>

<script setup>
import { Head, usePage, useForm } from "@inertiajs/vue3";
import AuthWithSidebarLayout from "@/Layouts/AuthWithSidebarLayout.vue";
import Box from "@/Components/Box.vue";
import { computed, ref } from "vue";
import { useShamsiNames, useShamsiDate } from "@/Composables/date.js"
import Breadcrumbs from "@/Components/Breadcrumbs.vue";

const props = defineProps({
    question: Object,
    levels: Object, 
    categories: Object
})

// Handle flash messages
const page = usePage()
const flashMessage = computed(() => {
    return page.props.flash.success
})

const flashMessageVisible = ref(true)
const flashMessageVisibleChange = (time) => 
{
    setTimeout(() => {
        flashMessageVisible.value = false
    }, time)   
}

// breadcrumbs
const breadcrumbs = [
    { label: 'داشبورد', url: route('dashboard') },
    { label: 'سوالات', url: route('questions.index') },
    { label: 'ویرایش سوال', url: route('questions.edit', props.question.id) },
];

// Date
const { shamsiYear, shamsiMonthNumber, shamsiMonth, shamsiDay } = useShamsiDate()
const { shamsiDayNames } = useShamsiNames()

const day = new Date().getDay()
const dateFormated = `${shamsiDayNames[day]} ${shamsiDay} ${shamsiMonth} ماه ${shamsiYear}`

// Form post
const form = useForm({
    level_id: props.question.level.id,
    category_id: props.question.category.id,
    question: props.question.text,
    answers: {
        correct: props.question.answers[0].text,
        answer_one: props.question.answers[1].text,
        answer_two: props.question.answers[2].text,
        answer_three: props.question.answers[3].text,
    }
})

const update = () => form.put(route('questions.update', props.question.id), {
    onSuccess: () => {
        flashMessageVisible.value = true

        flashMessageVisibleChange(2000)
    }, 
})
</script>