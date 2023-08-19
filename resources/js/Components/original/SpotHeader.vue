<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import StoreCategory from '@/Components/original/StoreCategory.vue';
import CategoryControls from '@/Components/original/CategoryControls.vue';
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
    selectedMap: {
        type: Array,
        required: false,
    },
    selectedCharacter: {
        type: Array,
        required: false,
    },
    routeName: {
        type: String,
        required: true,
    },
    showCategory: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
});

const selectedTag = ref(localStorage.getItem('selectedTag') || '');

const resetSelectedTag = () => {
    selectedTag.value = '';
    localStorage.removeItem('selectedTag');
    // 選択したマップとキャラクターがあれば、それらを含めて絞り込みを行う
    if (props.selectedMap && props.selectedCharacter) {
        Inertia.get(route('spots.index'), { selectedMap: props.selectedMap, selectedCharacter: props.selectedCharacter });
    } else {
        Inertia.get(route('spots.index'));
    }
};

const search = ref('');

const searchSpots = () => {
    Inertia.get(route('spots.index', { search: search.value }));
};

const resetSpots = () => {
    selectedTag.value = '';
    localStorage.removeItem('selectedTag');
    search.value = '';
    Inertia.get(route('spots.index'));
};
</script>

<template>
    <v-row>
        <v-col cols="6" class="flex">
            <v-text-field data-test="search-input" id="name" label="検索" v-model="search" class="ml-5 text-white search-spots" @keyup.enter="searchSpots"></v-text-field>
            <v-btn @click="searchSpots" class="search-button ml-5 mt-3">検索</v-btn>
            <v-btn @click="resetSpots" class="ml-2 mt-3">リセット</v-btn>
            <SpotFilter :maps="props.maps" :characters="props.characters" :tags="props.tags" :selectedMap="props.selectedMap" :selectedCharacter="props.selectedCharacter" :routeName="'spots.index'" />
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
    <div class="flex mx-5 mb-2">
        <CategoryControls :categories="categories" :showCategory="showCategory" />
    </div>
</template>