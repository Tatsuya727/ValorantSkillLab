<script setup>
import NavBar from '@/Components/original/NavBar.vue';
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
    spots: {
        type: Array,
        required: true,
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
</script>

<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-zinc-900">
            <v-container fluid>
                <v-row class="bg-neutral-700 pt-5 pb-10 mt-2 rounded">
                    <v-col v-for="category in props.categories" :key="category.id" cols="12" sm="6" md="4" lg="3" class="mt-10">
                        <!-- そのカテゴリーを持つ最初のspotを表示 -->
                        <div class="ml-4 cursor-pointer text-center" @click="selectCategory(category)">
                            <template v-if="getFirstSpotForCategory(category.id)">
                                <v-img :src="getFirstSpotForCategory(category.id)" class="min-w-full min-h-52 mr-4 rounded"></v-img>
                            </template>
                            <template v-else>
                                <div class="w-full h-52 bg-gray-400 mr-4 rounded"></div>
                            </template>
                            <div class="cursor-pointer">{{ category.name }}</div>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>
