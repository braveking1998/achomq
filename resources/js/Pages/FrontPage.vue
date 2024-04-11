<template>
    <Head title="اچم کیو" />
    <GuestLayout title="صفحه نخست">
        <!-- Features -->
        <section class="flex flex-col md:flex-row justify-center  items-center gap-8 lg:gap-12  mx-4 mt-8 lg:my-12">
            <div v-for="game in games" class="group w-2/3  md:w-1/3 lg:w-1/4 min-h-[250px]  border border-gray-300 p-4 rounded-lg flex flex-col items-center gap-4 hover:bg-gray-600 hover:text-gray-300 [&_img]:w-full">
                <div class="group-hover:bg-gray-400 w-28 border border-gray-800 text-center p-2 rounded-full bg-white">
                    <img :src="game.image" :alt="game.title">
                </div>
                <div class="font-bold">
                    {{ game.title }}
                </div>
                <div class="text-justify">
                    {{ game.description }}
                </div>
            </div>
        </section>

        <!-- The 3 tops -->
        <section class="bg-[url('/images/top-users.png')] bg-no-repeat bg-cover bg-center flex w-full pt-16 bg-slate-500 justify-center items-end gap-8 my-8">
            <TopUser class="order-2 h-32 transition-ease-out-500">
                <img src="/images/medals/gold.png" class="absolute w-12 mt-[-75px] mr-11" />
                احمد احمدپور
            </TopUser>
            <TopUser class="order-3 h-28 transition-ease-out-500">
                <img src="/images/medals/silver.png" class="absolute w-12 mt-[-75px] mr-11" />
                حامد احمدپور
            </TopUser>
            <TopUser class="order-1 h-24 transition-ease-out-500">
                <img src="/images/medals/bronze.png" class="absolute w-12 mt-[-75px] mr-11" />
                محمدرسول حسینی
            </TopUser>
        </section>

        <!-- Sponsors -->
        <section class="my-12 flex justify-center gap-8">

            <div v-for="sponsor in sponsors" class="group w-1/4 hover:opacity-70 transition-ease-out-500">
                <a href="#" target="_blank" rel="noopener noreferrer" class="block">
                    <img :src="sponsor.url" :title="sponsor.name" class=" block m-auto p-4 group-hover:p-0"/>
                </a>
            </div>
        </section>
    </GuestLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import TopUser from '@/Pages/FrontPage/Components/TopUser.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';

const games = [
    {
        'image': '/images/group-game1.png',
        'title': 'گروهی',
        'description': 'شما می توانید به صورت گروهی با دوستان خود رقابت کنید',
    },
    {
        'image': '/images/multi-player1.png',
        'title': 'دو نفره',
        'description': 'شما می توانید به صورت دو نفره با دوستان خود و به صورت تصادفی رقابت کنید',
    },
    {
        'image': '/images/single-player1.png',
        'title': 'تک نفره',
        'description': 'در این بازی شما می توانید اطلاعات خود را با پاسخ دادن به سوالات، بالا ببرید',
    },

]

const sponsors = [
    {
        'name': 'radio Achomestan',
        'url': '/images/sponsor-1.png',
    },
    {
        'name': 'sponsor 2',
        'url': '/images/sponsor-1.png',
    },
    {
        'name':'sponsor 3',
        'url': '/images/sponsor-1.png',
    }
]
</script>