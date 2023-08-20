<script setup>
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import NavBar from '@/Components/original/NavBar.vue';
import SpotHeader from '@/Components/original/SpotHeader.vue';
import CategoryMenu from '@/Components/original/CategoryMenu.vue';

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
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
});

const selectedCategory = ref(null);

// カテゴリーの名前をクリックすると、そのカテゴリーを持つspots.indexに遷移する
const selectCategory = (category) => {
    selectedCategory.value = category.id;
    Inertia.get(route('spots.index'), { category: selectedCategory.value });
};

// カテゴリーに関連する最初のスポットを取得
const getFirstSpotForCategory = (categoryId) => {
    const relatedSpot = props.spots.find((spot) => spot.categories && spot.categories[0].id === categoryId);

    if (relatedSpot) {
        return relatedSpot.images[0].image_path;
    }
};

const getSpotCountForCategory = (categoryId) => {
    return props.spots.filter((spot) => spot.categories && spot.categories.some((cat) => cat.id === categoryId)).length;
};
</script>

<template>
    <v-app id="inspire">
        <NavBar />
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
                    />
                    <v-row class="mx-5">
                        <v-col v-for="category in props.categories" :key="category.id" cols="12" sm="6" md="4" lg="3" class="mt-10">
                            <!-- そのカテゴリーを持つ最初のspotを表示 -->
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
