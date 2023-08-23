<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { defineEmits, ref, computed } from 'vue';
import SpotTags from '@/Components/original/SpotTags.vue';
import SpotMenu from '@/Components/original/SpotMenu.vue';

const props = defineProps({
    spots: {
        type: Array,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    selectedTag: {
        type: String,
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
    selectedCategory: {
        type: Number,
        required: false,
    },
    userCategories: {
        type: Array,
        required: false,
    },
    flash: Object,
});

const selectedCategoryId = props.selectedCategory;

const currentCategoryName = computed(() => {
    const categoryId = Number(selectedCategoryId);
    if (categoryId) {
        return props.categories.find((category) => category.id === categoryId).name;
    }
});

// 選択した物が何もない場合
const noSelected = computed(() => {
    return !props.selectedMap && !props.selectedCharacter && !props.selectedTag && !props.selectedCategory;
});
</script>

<template>
    <v-divider></v-divider>
    <v-row justify="center" class="">
        <v-col cols="12">
            <h1 v-if="currentCategoryName" class="mt-5 text-white text-center font-bold">{{ currentCategoryName }}({{ spots.data.length }})</h1>
            <h1 v-if="noSelected" class="mt-5 text-white text-center font-bold">すべて表示({{ spots.data.length }})</h1>
        </v-col>
        <v-expand-transition>
            <v-col cols="11">
                <v-row justify="center" class="mx-3">
                    <v-col v-if="spots.data.length === 0" cols="12" class="text-white text-center text-lg font-bold">無し</v-col>
                    <v-col v-for="spot in props.spots.data" :key="spot.id" cols="12" sm="6" md="4" lg="3" class="mt-10">
                        <div class="flex flex-col rounded overflow-hidden relative h-full">
                            <!-- 画像 -->
                            <Link :href="spot.show_url" class="flex-grow">
                                <v-img cover class="cursor-pointer h-full" :src="spot.images[0].image_path" alt="サムネイル画像" loading="lazy"></v-img>
                            </Link>
                            <!-- 情報 -->
                            <div class="p-4 bg-neutral-800">
                                <div class="absolute top-50 right-0 mr-2 flex cursor-pointer">
                                    <SpotMenu :spot="spot" :userCategories="userCategories" :flash="flash" />
                                </div>
                                <div>
                                    <h2 class="text-gray-700 text-white spot-title">
                                        {{ spot.title }}
                                    </h2>
                                    <p class="text-sm text-gray-700 text-grey">
                                        map: <span class="font-bold text-white map-name">{{ spot.map.name }}</span>
                                    </p>
                                    <p class="text-sm text-gray-700 text-grey">
                                        character: <span class="font-bold text-white character-name">{{ spot.character.name }}</span>
                                    </p>
                                    <!-- タグの名前をすべて表示 -->
                                    <div class="flex flex-wrap mt-2">
                                        <SpotTags
                                            :tags="spot.tags"
                                            :selectedMap="props.selectedMap"
                                            :selectedCharacter="props.selectedCharacter"
                                            :selectedCategory="selectedCategory"
                                            :routeName="'spots.index'"
                                        />
                                    </div>
                                    <div class="text-green text-right">{{ spot.user.name }}</div>
                                </div>
                            </div>
                        </div>
                    </v-col>
                </v-row>
            </v-col>
        </v-expand-transition>
    </v-row>
</template>
