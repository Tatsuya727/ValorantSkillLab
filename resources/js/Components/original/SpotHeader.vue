<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import StoreCategory from '@/Components/original/StoreCategory.vue';
import SpotFilter from '@/Components/original/SpotFilter.vue';

const props = defineProps({
    maps: {
        type: Array,
        required: true,
    },
    characters: {
        type: Array,
        required: true,
    },
    tags: {
        type: Array,
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
    selectedCategory: {
        type: Object,
        required: false,
    },
    categories: {
        type: Array,
        required: true,
    },
    inCategory: {
        type: Boolean,
        required: true,
    },
});
const resetSelectedTag = () => {
    props.selectedTag = '';
    // 選択したマップとキャラクターがあれば、それらを含めて絞り込みを行う
    if (props.selectedMap || props.selectedCharacter || props.selectedCategory) {
        Inertia.get(route('spots.index'), { selectedMap: props.selectedMap, selectedCharacter: props.selectedCharacter, category: props.selectedCategory });
    } else {
        Inertia.get(route('spots.index'));
    }
};

const search = ref('');

const searchSpots = () => {
    Inertia.get(route('spots.index', { search: search.value, category: props.selectedCategory }));
};

const resetSpots = () => {
    selectedTag.value = '';
    selectedMap.value = '';
    selectedCharacter.value = '';
    search.value = '';
    Inertia.get(route('spots.index', { category: props.selectedCategory }));
};
</script>

<template>
    <v-row>
        <v-col cols="6" class="flex">
            <v-text-field data-test="search-input" id="name" label="検索" v-model="search" class="ml-5 text-white search-spots" @keyup.enter="searchSpots"></v-text-field>
            <v-btn @click="searchSpots" class="search-button ml-5 mt-3">検索</v-btn>
            <v-btn v-if="!inCategory" @click="resetSpots" class="ml-2 mt-3" color="red">リセット</v-btn>
            <SpotFilter
                :maps="maps"
                :characters="characters"
                :tags="tags"
                :selectedMap="selectedMap"
                :selectedCharacter="selectedCharacter"
                :selectedCategory="selectedCategory"
                :categories="categories"
                :routeName="'spots.index'"
            />
        </v-col>
        <v-col class="flex">
            <div class="text-grey ml-3">
                <div>
                    選択したマップ:
                    <span v-if="selectedMap" class="text-white text-lg font-bold">{{ selectedMap.name }}</span>
                    <span v-else class="text-white text-lg font-bold">無し</span>
                </div>
                <div>
                    選択したキャラクター:
                    <span v-if="selectedCharacter" class="text-white text-lg font-bold">{{ selectedCharacter.name }}</span>
                    <span v-else class="text-white text-lg font-bold">無し</span>
                </div>
            </div>
            <div class="text-grey ml-10 mt-3">
                タグ:
                <v-chip v-if="selectedTag" color="light-blue-lighten-5" close closable @click="resetSelectedTag"> {{ selectedTag }} </v-chip>
            </div>
        </v-col>
        <v-col>
            <StoreCategory />
        </v-col>
    </v-row>
</template>
