<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { defineProps, ref, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Pagination from '@/Components/original/Pagination.vue';
import LikeButton from '@/Components/original/LikeButton.vue';
import ShareSpotMenu from '@/Components/original/ShareSpotMenu.vue';
import SpotTags from '@/Components/original/SpotTags.vue';
import OrderButton from '@/Components/original/OrderButton.vue';
import { useMobileDetection } from '@/Hooks/useMobileDetection';
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
        type: Object,
        required: false,
    },
    selectedMap: {
        type: Object,
        required: false,
    },
    selectedCharacter: {
        type: Object,
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
    search: {
        type: String,
        required: false,
    },
    userCategories: {
        type: Array,
        required: false,
    },
    orderBy: {
        type: String,
        required: false,
    },
    flash: Object,
});

const { isMobile } = useMobileDetection();

const filterMap = (map) => {
    Inertia.get(route('sharespots.index', { selectedMap: map }));
};

const filterCharacter = (character) => {
    Inertia.get(route('sharespots.index', { selectedCharacter: character }));
};

onMounted(() => {
    const savedState = localStorage.getItem('isVertical');
    if (savedState !== null) {
        isVertical.value = savedState === 'true';
    }
});

const isVertical = ref(false);

const setVertical = () => {
    isVertical.value = true;
    localStorage.setItem('isVertical', 'true');
};

const setHorizontal = () => {
    isVertical.value = false;
    localStorage.setItem('isVertical', 'false');
};
</script>

<template>
    <div class="flex justify-between items-center">
        <div class="flex-grow text-center">
            <div v-if="props.spots.data.length === 0" class="mt-10 text-white text-lg title">検索結果無し</div>
            <div v-else-if="spotsCount < allSpotsCount" class="mt-5 text-white text-lg title">
                検索結果
                <span class="text-3xl">{{ props.spotsCount }}</span>
                件
            </div>
            <div v-else class="mt-5 text-white text-lg title">
                すべての投稿
                <span class="text-3xl">{{ props.allSpotsCount }}</span>
                件
            </div>
        </div>
        <div class="mr-5 flex">
            <OrderButton
                :selectedMap="props.selectedMap"
                :selectedCharacter="props.selectedCharacter"
                :selectedTag="props.selectedTag"
                :search="props.search"
                :orderBy="props.orderBy"
                :routeName="'sharespots.index'"
            />
            <div v-if="!isMobile" class="ml-8 mt-2">
                <v-icon @click="setHorizontal" class="text-white cursor-pointer mr-3">mdi-apps</v-icon>
                <v-icon @click="setVertical" class="text-white cursor-pointer">mdi-menu</v-icon>
            </div>
        </div>
    </div>

    <Pagination class="mt-5 text-white" :links="props.spots.links"></Pagination>

    <v-row v-if="isVertical" justify="center" class="mx-3">
        <v-col v-for="spot in props.spots.data" :key="spot.id" cols="10" sm="12" md="10" lg="10" class="mt-10">
            <div class="flex flex-row rounded relative h-full">
                <!-- 画像 -->
                <Link :href="spot.show_url" class="flex-1">
                    <v-img cover class="cursor-pointer h-full w-full" :src="spot.images[0].image_path" alt="サムネイル画像" loading="lazy"></v-img>
                </Link>
                <!-- 情報 -->
                <div class="p-4 bg-neutral-800 flex-1">
                    <div class="absolute top-50 right-0 mr-2 flex cursor-pointer">
                        <ShareSpotMenu :spot="spot" :userCategories="userCategories" :flash="flash" />
                    </div>
                    <div class="mb-4 pt-5 pl-2">
                        <h2 class="text-gray-700 text-white spot-title whitespace-normal">
                            {{ spot.title }}
                        </h2>
                        <p class="text-lg text-gray-700 text-grey mt-7">
                            map:
                            <span
                                :class="{
                                    'font-bold text-white map-name cursor-pointer hover:underline': !selectedMap,
                                    'font-bold text-orange-400 map-name cursor-pointer hover:underline': selectedMap,
                                }"
                                @click="filterMap(spot.map)"
                                >{{ spot.map.name }}</span
                            >
                        </p>
                        <p class="text-lg text-gray-700 text-grey">
                            character:
                            <span
                                :class="{
                                    'font-bold text-white character-name cursor-pointer hover:underline': !selectedCharacter,
                                    'font-bold text-orange-400 character-name cursor-pointer hover:underline': selectedCharacter,
                                }"
                                @click="filterCharacter(spot.character)"
                            >
                                {{ spot.character.name }}
                            </span>
                        </p>
                        <!-- いいねとタグの名前をすべて表示 -->
                        <div class="flex flex-wrap mt-5">
                            <LikeButton class="mt-2 mr-2" :spot="spot" />
                            <SpotTags :tags="spot.tags" :selectedTag="selectedTag" :selectedMap="props.selectedMap" :selectedCharacter="props.selectedCharacter" :routeName="'sharespots.index'" />
                        </div>
                    </div>
                    <div class="absolute bottom-0 right-0 mb-2 mr-2 flex justify-between">
                        <div class="text-gray-400 mx-3 text-sm">{{ dayjs(spot.created_at).format('YYYY年MM月DD日') }}</div>
                        <!-- ユーザーネーム -->
                        <div class="text-green mr-2 user-name">{{ spot.user.name }}</div>
                    </div>
                </div>
            </div>
        </v-col>
    </v-row>

    <v-row v-else justify="center" class="mx-3">
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
                    <div class="mb-4">
                        <v-tooltip :text="spot.title" location="top">
                            <template v-slot:activator="{ props }">
                                <h2 v-bind="props" class="text-gray-700 text-white spot-title truncate">
                                    {{ spot.title }}
                                </h2>
                            </template>
                        </v-tooltip>
                        <p class="text-sm text-gray-700 text-grey">
                            map:
                            <span
                                :class="{
                                    'font-bold text-white map-name cursor-pointer hover:underline': !selectedMap,
                                    'font-bold text-orange-400 map-name cursor-pointer hover:underline': selectedMap,
                                }"
                                @click="filterMap(spot.map)"
                                >{{ spot.map.name }}</span
                            >
                        </p>
                        <p class="text-sm text-gray-700 text-grey">
                            character:
                            <span
                                :class="{
                                    'font-bold text-white character-name cursor-pointer hover:underline': !selectedCharacter,
                                    'font-bold text-orange-400 character-name cursor-pointer hover:underline': selectedCharacter,
                                }"
                                @click="filterCharacter(spot.character)"
                            >
                                {{ spot.character.name }}
                            </span>
                        </p>
                        <!-- タグの名前をすべて表示 -->
                        <div class="flex flex-wrap">
                            <LikeButton class="mt-2 mr-2" :spot="spot" />
                            <SpotTags :tags="spot.tags" :selectedTag="selectedTag" :selectedMap="props.selectedMap" :selectedCharacter="props.selectedCharacter" :routeName="'sharespots.index'" />
                        </div>
                    </div>
                    <div class="absolute bottom-0 right-0 mb-2 mr-2 flex justify-between">
                        <div class="text-gray-400 mx-3 text-sm">{{ dayjs(spot.created_at).format('YYYY年MM月DD日') }}</div>
                        <!-- ユーザーネーム -->
                        <div class="text-green user-name">{{ spot.user.name }}</div>
                    </div>
                </div>
            </div>
        </v-col>
    </v-row>
    <Pagination class="mt-5 text-white" :links="props.spots.links"></Pagination>
</template>

<style scoped>
.truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
