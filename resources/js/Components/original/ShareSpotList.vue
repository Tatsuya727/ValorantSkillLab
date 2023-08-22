<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Pagination from '@/Components/original/Pagination.vue';
import LikeButton from '@/Components/original/LikeButton.vue';
import ShareSpotMenu from '@/Components/original/ShareSpotMenu.vue';
import SpotTags from '@/Components/original/SpotTags.vue';

import dayjs from 'dayjs';

const props = defineProps({
    spots: {
        type: Array,
        required: true,
    },
    categories: {
        type: Object,
        required: true,
    },
    selectedTag: {
        type: String,
        required: false,
    },
    allSpotsCount: {
        type: Number,
        required: true,
    },
    spotsCount: {
        type: Number,
        required: true,
    },
    userCategories: {
        type: Array,
        required: false,
    },
    selectedMap: {
        type: Array,
        required: false,
    },
    selectedCharacter: {
        type: Array,
        required: false,
    },
    flash: Object,
});
</script>

<template>
    <div>
        <div v-if="props.spots.data.length === 0" class="mt-10 text-center text-white text-lg">検索結果無し</div>
        <div v-else-if="spotsCount < allSpotsCount" class="mt-5 text-center text-white text-lg">
            検索結果
            <span class="text-3xl">{{ props.spotsCount }}</span>
            件
        </div>
        <div v-else class="mt-5 text-center text-white text-lg">
            すべての投稿
            <span class="text-3xl">{{ props.allSpotsCount }}</span>
            件
        </div>
    </div>
    <Pagination class="mt-5 text-white" :links="props.spots.links"></Pagination>

    <v-row justify="center" class="mx-3">
        <v-col v-for="spot in props.spots.data" :key="spot.id" cols="12" sm="6" md="4" lg="3" class="mt-10">
            <div class="flex flex-col rounded overflow-hidden relative h-full">
                <!-- 画像 -->
                <Link :href="spot.show_url" class="flex-grow">
                    <v-img cover class="cursor-pointer h-full" :src="spot.images[0].image_path" alt="サムネイル画像" loading="lazy"></v-img>
                </Link>
                <!-- 情報 -->
                <div class="p-4 bg-neutral-800">
                    <div class="absolute top-50 right-0 mr-2 flex cursor-pointer">
                        <ShareSpotMenu :spot="spot" :userCategories="userCategories" :flash="flash" />
                    </div>
                    <div class="flex mb-2">
                        <Link :href="spot.show_url">
                            <h1 class="text-2xl font-bold text-white">{{ spot.title }}</h1>
                            <div class="mt-2">
                                <p class="text-sm text-gray-400">
                                    category: <span class="font-bold text-white">{{ spot.categories[0].name }}</span>
                                </p>
                                <p class="text-sm text-gray-400">
                                    map: <span class="font-bold text-white">{{ spot.map.name }}</span>
                                </p>
                                <p class="text-sm text-gray-400">
                                    character: <span class="font-bold text-white">{{ spot.character.name }}</span>
                                </p>
                            </div>
                        </Link>
                        <!-- タグの名前をすべて表示 -->
                        <div class="flex flex-wrap mt-7">
                            <SpotTags :tags="spot.tags" :selectedMap="props.selectedMap" :selectedCharacter="props.selectedCharacter" :routeName="'sharespots.index'" />
                        </div>
                    </div>
                    <LikeButton :spot="spot" />
                    <div class="absolute bottom-0 right-0 mb-2 mr-2 flex justify-between">
                        <div class="text-gray-400 mx-3 text-sm">{{ dayjs(spot.created_at).format('YYYY年MM月DD日') }}</div>
                        <!-- ユーザーネーム -->
                        <div class="text-green">{{ spot.user.name }}</div>
                    </div>
                </div>
            </div>
        </v-col>
    </v-row>
    <Pagination class="mt-5 text-white" :links="props.spots.links"></Pagination>
</template>
