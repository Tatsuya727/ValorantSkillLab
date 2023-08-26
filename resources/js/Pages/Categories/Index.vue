<script setup>
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import NavBar from '@/Components/original/NavBar.vue';
import SpotHeader from '@/Components/original/SpotHeader.vue';
import CategoryMenu from '@/Components/original/CategoryMenu.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    spots: {
        type: Array,
        required: true,
    },
    maps: {
        type: Array,
        required: false,
    },
    characters: {
        type: Array,
        required: false,
    },
    tags: {
        type: Array,
        required: false,
    },
    categories: {
        type: Array,
        required: true,
    },
});

const selectedCategory = ref(null);

// カテゴリーの名前をクリックすると、そのカテゴリーを持つspots.indexに遷移する
const selectCategory = (category) => {
    selectedCategory.value = category;
    Inertia.get(route('spots.index'), { category: selectedCategory.value });
};

// カテゴリーに関連する最初のスポットを取得
const getFirstSpotForCategory = (categoryId) => {
    const relatedSpot = props.spots.find((spot) => spot.categories && spot.categories.some((category) => category.id === categoryId));

    if (relatedSpot) {
        return relatedSpot.images[0].image_path;
    }
};

const getSpotCountForCategory = (categoryId) => {
    return props.spots.filter((spot) => spot.categories && spot.categories.some((cat) => cat.id === categoryId)).length;
};

// ここがカテゴリー一覧ページであることを示すフラグ
const inCategory = true;

const pageTitle = 'マイページ';
</script>

<template>
    <Head :title="pageTitle" />

    <v-app id="inspire">
        <NavBar :pageTitle="pageTitle" />
        <v-main class="bg-zinc-900">
            <v-container fluid>
                <div class="bg-neutral-700 pt-5 pb-10 mt-2 rounded">
                    <SpotHeader
                        :maps="maps"
                        :characters="characters"
                        :tags="tags"
                        :selectedMap="selectedMap"
                        :selectedCharacter="selectedCharacter"
                        :showCategory="showCategory"
                        :categories="categories"
                        :inCategory="inCategory"
                    />
                    <v-row class="mx-5">
                        <!-- すべてのカテゴリーを表示するカード -->
                        <v-col cols="12" sm="6" md="4" lg="3" class="mt-10">
                            <div class="ml-4 cursor-pointer text-center flex items-center justify-center relative" @click="Inertia.get(route('spots.index'))">
                                <div class="w-full h-52 bg-gray-400 mr-4 rounded"></div>
                                <div class="absolute cursor-pointer text-white text-xl font-bold font-sans">すべて</div>
                            </div>
                        </v-col>

                        <v-col v-for="category in props.categories" :key="category.id" cols="12" sm="6" md="4" lg="3" class="mt-10">
                            <div class="ml-4 cursor-pointer text-center flex items-center justify-center relative" @click="selectCategory(category)">
                                <!-- 画像 -->
                                <template v-if="getFirstSpotForCategory(category.id)">
                                    <v-img :src="getFirstSpotForCategory(category.id)" class="min-w-full min-h-52 mr-4 rounded blur"></v-img>
                                    <!-- カテゴリーメニュー -->
                                    <div class="absolute top-2 right-2 z-10">
                                        <CategoryMenu :category="category" />
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="w-full h-52 bg-gray-400 mr-4 rounded"></div>
                                    <!-- カテゴリーメニュー -->
                                    <div class="absolute top-2 right-5 z-10">
                                        <CategoryMenu :category="category" />
                                    </div>
                                </template>
                                <!-- 名前 -->
                                <div class="absolute cursor-pointer text-white text-xl font-bold font-sans">{{ category.name }} ({{ getSpotCountForCategory(category.id) }})</div>
                            </div>
                            <!-- <div class="cursor-pointer text-center text-white text-xl font-bold font-sans">{{ category.name }} ({{ getSpotCountForCategory(category.id) }})</div> -->
                        </v-col>

                        <!-- いいねしたspotを表示するカード -->
                        <v-col cols="12" sm="6" md="4" lg="3" class="mt-10">
                            <div class="ml-4 cursor-pointer text-center flex items-center justify-center relative" @click="Inertia.get(route('spots.index', { liked: true }))">
                                <div class="w-full h-52 bg-gray-400 mr-4 rounded"></div>
                                <div class="absolute cursor-pointer text-white text-xl font-bold font-sans">いいね</div>
                            </div>
                        </v-col>
                    </v-row>
                </div>
            </v-container>
        </v-main>
    </v-app>
</template>

<style scoped>
.blur {
    filter: blur(2px);
}
</style>
