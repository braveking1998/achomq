<template>
    <Head title="همه سوالات" />
    <AuthWithoutSidebarLayout>

        <template #header>
            <Breadcrumbs :breadcrumbs="breadcrumbs">
                <template #right-side>
                    <Link :href="route('questions.create')" class="btn-primary hidden md:block">افزودن سوال</Link>
                </template>
            </Breadcrumbs>
        </template>
        <template #content>
            <!-- Flash messages -->
            <div v-show="flashMessage && flashMessageVisible" @click="flashMessageVisible = !flashMessageVisible" class="flash-message bg-red-500">
                {{ flashMessage }}
            </div>
            <Box class="p-6 mb-6">
                <form @submit.prevent="filter">
                    <div class="grid grid-cols-1 md:grid-cols-3 place-content-center">
                        <div class="flex items-center justify-center gap-4">
                            <label for="category" class="w-1/3 md:w-auto">دسته بندی:</label>
                            <select id="category" class="input w-2/3" v-model="form.category">
                                <option value="0" selected>همه دسته بندی ها</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-center gap-4">
                            <label for="level" class="w-1/3 md:w-auto">سطح:</label>
                            <select id="level" class="input w-2/3" v-model="form.level">
                                <option value="0" selected>همه سطوح</option>
                                <option v-for="level in levels" :key="level.id" :value="level.id">{{ level.name }}</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-center gap-4">
                            <input type="text" placeholder="متن خود را جستجو کنید" class="input w-2/3" v-model="form.text"/>
                            <button type="submit" class="btn-primary mt-2">جستجو</button>
                        </div>
                    </div>
                </form>
            </Box>
            <Box class="p-6">
                <table class="w-full table-auto border border-gray-500 border-collapse text-base font-medium text-gray-500">
                    <thead>
                        <tr>
                            <th class="border border-gray-500 p-2 md:p-4">ردیف</th>
                            <th class="border border-gray-500">متن سوال</th>
                            <th class="border border-gray-500">دسته بندی</th>
                            <th class="border border-gray-500">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(question, index) in questions.data" :key="question.id">
                            <td class="border border-gray-500 md:p-2 text-center">{{ questions.from + index }}</td>
                            <td class="border border-gray-500 md:pr-4">{{ question.text }}</td>
                            <td class="border border-gray-500 text-center">
                                <Link class="text-indigo-800 underline italic" :href="route('questions.index', {category: question.category.id})">
                                    {{ question.category.name }}
                                </Link>
                            </td>
                            <td class="border border-gray-500">
                                <div class="flex flex-col md:flex-row gap-2 my-2 md:m-2 items-center justify-center">
                                    <Link :href="route('questions.show', question.id)" class="btn-primary text-center px-2 md:px-4">نمایش</Link>
                                    <Link :href="route('questions.edit', question.id)" class="btn-primary text-center bg-green-500 px-2 md:px-4">ویرایش</Link>
                                    <button @click="deleteQuestion(question.id)" class="btn-primary text-center bg-red-500 px-2 md:px-4">حذف</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="questions.data.length" class="w-full flex justify-center my-8">
                    <Pagination :links="questions.links" />
                </div>
            </Box>
        </template>
    </AuthWithoutSidebarLayout>
</template>

<script setup>
import AuthWithoutSidebarLayout from '@/Layouts/AuthWithoutSidebarLayout.vue';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';
import Box from '@/Components/Box.vue'
import { computed, ref } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    filters: Object,
    questions: Object,
    categories: Object,
    levels: Object
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
];

const form = useForm({
    category: props.filters.category ?? 0,
    level: props.filters.level ?? 0,
    text: props.filters.text ?? '',
})

const filter = () => form.get(route('questions.index'), {
    preserveScroll: true
})

const deleteQuestion = (id) => {
    const form = useForm({
        id: id
    })

    form.delete(route('questions.destroy', id), {
        onSuccess: () => {
            form.reset(),

            flashMessageVisible.value = true

            flashMessageVisibleChange(2000)
        },
    })
}
</script>