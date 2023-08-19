<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { defineEmits, ref, computed } from 'vue';
import SpotTags from '@/Components/original/SpotTags.vue';
import CategoryHeader from '@/Components/original/CategoryHeader.vue';
import SpotMenu from '@/Components/original/SpotMenu.vue';

const props = defineProps({
    spots: {
        type: Array,
        required: true,
    },
    category: {
        type: Object,
        required: true,
    },
    showCategory: {
        type: Object,
        required: true,
    },
    selectedTag: {
        type: String,
        required: false,
    },
    selectedMap: {
        type: Number,
        required: false,
    },
    selectedCharacter: {
        type: Number,
        required: false,
    },
});

// category.id と一致する spot のみをフィルタリングする computed property
const filteredSpots = computed(() => {
    return props.spots.filter((spot) => spot.category_id === props.category.id);
});

// 親コンポーネントにfilteredSpotsを返す
const emits = defineEmits(['filteredSpots']);

// カテゴリーの表示・非表示を切り替える
if (props.categories) {
    props.categories.forEach((category) => {
        showCategory[category.id] = true;
    });
}
</script>

<template>
    <!-- カテゴリーヘッダー -->
    <CategoryHeader :category="category" :showCategory="showCategory" :filteredSpots="filteredSpots" />
    <v-expand-transition>
        <v-col cols="11" v-if="showCategory[category.id]">
            <v-row justify="center" class="mx-3">
                <v-col v-if="filteredSpots.length === 0" cols="12" class="text-white text-center text-lg font-bold">無し</v-col>
                <v-col v-for="spot in filteredSpots" :key="spot.id" cols="12" sm="6" md="4" lg="3" class="mt-10">
                    <div class="flex flex-col rounded overflow-hidden relative h-full">
                        <!-- 画像 -->
                        <Link :href="spot.show_url" class="flex-grow">
                            <v-img cover class="cursor-pointer h-full" :src="spot.images[0].image_path" alt="サムネイル画像" loading="lazy"></v-img>
                        </Link>
                        <!-- 情報 -->
                        <div class="p-4 bg-neutral-800">
                            <div class="absolute top-50 right-0 mr-2 flex cursor-pointer">
                                <SpotMenu :spot="spot" />
                            </div>
                            <div class="flex mb-2">
                                <div>
                                    <p class="text-sm text-gray-700 text-white">
                                        title: <span class="font-bold display-block">{{ spot.title }}</span>
                                    </p>
                                    <p class="text-sm text-gray-700 text-white">
                                        map: <span class="font-bold">{{ spot.map.name }}</span>
                                    </p>
                                    <p class="text-sm text-gray-700 text-white">
                                        character: <span class="font-bold">{{ spot.character.name }}</span>
                                    </p>
                                </div>

                                <!-- タグの名前をすべて表示 -->
                                <div class="flex flex-wrap mt-7">
                                    <SpotTags :tags="spot.tags" :selectedMap="props.selectedMap" :selectedCharacter="props.selectedCharacter" :routeName="'sharespots.index'" />
                                </div>
                            </div>
                        </div>
                    </div>
                </v-col>
            </v-row>
        </v-col>
    </v-expand-transition>
</template>
