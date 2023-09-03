<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import StoreCategory from '@/Components/original/StoreCategory.vue';
import SpotFilter from '@/Components/original/SpotFilter.vue';
import { useMobileDetection } from '@/Hooks/useMobileDetection';

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
    search: {
        type: String,
        required: false,
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

const { isMobile } = useMobileDetection();

// 画面上部に表示されたタグをクリックすると、タグの絞り込みを解除する
const resetSelectedTag = () => {
    props.selectedTag = '';
    Inertia.get(route('spots.index', { selectedMap: props.selectedMap, selectedCharacter: props.selectedCharacter, category: props.selectedCategory }));
};

// マップの絞り込みを解除する
const resetSelectedMap = () => {
    props.selectedMap = '';
    Inertia.get(route('spots.index', { selectedCharacter: props.selectedCharacter, selectedTag: props.selectedTag, category: props.selectedCategory }));
};

// キャラクターの絞り込みを解除する
const resetSelectedCharacter = () => {
    props.selectedCharacter = '';
    Inertia.get(route('spots.index', { selectedMap: props.selectedMap, selectedTag: props.selectedTag, category: props.selectedCategory }));
};

const search = ref(props.search ? props.search : '');

const searchSpots = () => {
    Inertia.get(route('spots.index', { search: search.value, category: props.selectedCategory }));
};

const resetSpots = () => {
    Inertia.get(route('spots.index', { category: props.selectedCategory }));
};
</script>

<template>
    <!-- デスクトップ（モバイル以外） -->
    <v-row v-if="!isMobile">
        <v-col cols="6" class="flex">
            <v-text-field data-test="search-input" id="name" label="検索" v-model="search" clearable="" class="ml-5 text-white search-spots" @keyup.enter="searchSpots"></v-text-field>
            <v-btn @click="searchSpots" class="search-button ml-5 mt-3">検索</v-btn>
            <v-btn v-if="!inCategory" @click="resetSpots" class="ml-2 mt-3" color="red">リセット</v-btn>
            <SpotFilter
                :maps="maps"
                :characters="characters"
                :tags="tags"
                :selectedTag="selectedTag"
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
                    マップ:
                    <v-chip v-if="selectedMap" class="selected-map" color="light-blue-lighten-5" closable @click="resetSelectedMap">{{ selectedMap.name }}</v-chip>
                    <span v-else class="text-white text-lg font-bold">無し</span>
                </div>
                <div>
                    キャラクター:
                    <v-chip v-if="selectedCharacter" color="light-blue-lighten-5" closable class="mt-1 selected-character" @click="resetSelectedCharacter">{{ selectedCharacter.name }}</v-chip>
                    <span v-else class="text-white text-lg font-bold">無し</span>
                </div>
            </div>
            <div class="text-grey ml-10 mt-3">
                タグ:
                <v-chip v-if="selectedTag" color="light-blue-lighten-5" class="selected-tag" closable @click="resetSelectedTag"> {{ selectedTag }} </v-chip>
                <span v-else class="text-white text-lg font-bold">無し</span>
            </div>
        </v-col>
        <v-col>
            <StoreCategory />
        </v-col>
    </v-row>
    <!-- モバイル端末 -->
    <v-row v-if="isMobile">
        <v-col cols="12" class="flex justify-between">
            <SpotFilter
                :maps="maps"
                :characters="characters"
                :tags="tags"
                :selectedTag="selectedTag"
                :selectedMap="selectedMap"
                :selectedCharacter="selectedCharacter"
                :selectedCategory="selectedCategory"
                :categories="categories"
                :routeName="'spots.index'"
            />
            <div>
                <v-btn @click="searchSpots" class="search-button mr-2 mt-3">検索</v-btn>
                <v-btn v-if="!inCategory" @click="resetSpots" class="mx-2 mt-3" color="red">リセット</v-btn>
            </div>
        </v-col>
        <v-col cols="12">
            <v-text-field data-test="search-input" id="name" label="検索" v-model="search" class="mx-5 text-white search-spots" @keyup.enter="searchSpots"></v-text-field>
        </v-col>
        <v-col class="flex">
            <div class="text-grey ml-10">
                <div>
                    マップ:
                    <v-chip v-if="selectedMap" color="light-blue-lighten-5" closable @click="resetSelectedMap">{{ selectedMap.name }}</v-chip>
                    <span v-else class="text-white text-lg font-bold">無し</span>
                </div>
                <div>
                    キャラクター:
                    <v-chip v-if="selectedCharacter" color="light-blue-lighten-5" closable class="mt-1" @click="resetSelectedCharacter">{{ selectedCharacter.name }}</v-chip>
                    <span v-else class="text-white text-lg font-bold">無し</span>
                </div>
            </div>
            <div class="text-grey ml-10 mt-3">
                タグ:
                <v-chip v-if="selectedTag" color="light-blue-lighten-5" closable @click="resetSelectedTag"> {{ selectedTag }} </v-chip>
                <span v-else class="text-white text-lg font-bold">無し</span>
            </div>
        </v-col>
    </v-row>
</template>
