<script setup>
import NavBar from '@/Components/NavBar.vue';
import { defineProps, reactive } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    spots: {
        type: Array,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
});

// 各カテゴリーの表示状態を管理するオブジェクト
const showCategory = reactive({});

// 初期状態では全てのカテゴリーを表示する
props.categories.forEach((category) => {
    showCategory[category.id] = true;
});

// カテゴリーの表示状態を切り替える関数
const toggleCategory = (categoryId) => {
    showCategory[categoryId] = !showCategory[categoryId];
};
</script>

<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2">
            <v-container>
                <v-row v-if="props.spots">
                    <template v-for="(category, index) in props.categories" :key="category.id">
                        <v-col class="mt-4" cols="12">
                            <h4 class="text-2xl font-bold cursor-pointer" @click="toggleCategory(category.id)">
                                <v-icon v-if="showCategory[category.id]">mdi-chevron-down</v-icon>
                                <v-icon v-else>mdi-chevron-right</v-icon>
                                {{ category.name }}
                                <v-icon>mdi-dots-vertical</v-icon>
                            </h4>
                        </v-col>
                        <v-expand-transition>
                            <v-col cols="12" v-if="showCategory[category.id]">
                                <div class="flex flex-wrap mx-auto gap-4">
                                    <v-slide-group v-model="model" class="" selected-class="bg-success" show-arrows>
                                        <v-slide-group-item v-for="spot in props.spots" :key="spot.id">
                                            <div
                                                v-if="spot.category_id === category.id"
                                                class="flex flex-col items-center w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-2/12 mb-4 bg-white rounded shadow mr-5"
                                            >
                                                <Link :href="spot.show_url">
                                                    <img :width="431" cover class="rounded-t" :src="spot.images[0].image_path" alt="" />
                                                </Link>
                                                <div class="p-4">
                                                    <p class="text-sm text-gray-700">{{ spot.description }}</p>
                                                </div>
                                            </div>
                                        </v-slide-group-item>
                                    </v-slide-group>
                                </div>
                            </v-col>
                        </v-expand-transition>
                    </template>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<!-- <template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2">
            <v-container>
                <v-row v-if="props.spots">
                    <strong>Category 1</strong>
                    <v-col class="mt-2" cols="12">
                        <div class="flex mx-auto p-10 gap-4">
                            <div v-for="(spot, index) in props.spots" :key="spot.id" class="w-1/6 bg-cyan-400">
                                <div v-for="(image, index) in spot.images" :key="index" class="bg-green-300">
                                    <div v-if="index === 0">
                                        <p>{{ spot.description }}</p>
                                        <Link :href="spot.show_url">
                                            <img class="w-full h-auto" :src="image.image_path" alt="" />
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template> -->
