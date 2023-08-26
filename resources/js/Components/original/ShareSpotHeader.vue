<script setup>
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { useMobileDetection } from '@/Hooks/useMobileDetection';
import SpotFilter from '@/Components/original/SpotFilter.vue';

const props = defineProps({
    maps: Array,
    characters: Array,
    tags: Array,
    categories: Array,
    selectedTag: Object,
    selectedMap: Object,
    selectedCharacter: Object,
    selectedCategory: Object,
});

const { isMobile } = useMobileDetection();

// 画面上部に表示されたタグをクリックすると、タグの絞り込みを解除する
const resetSelectedTag = () => {
    props.selectedTag = '';
    Inertia.get(route('sharespots.index', { selectedMap: props.selectedMap, selectedCharacter: props.selectedCharacter, category: props.selectedCategory }));
};

// マップの絞り込みを解除する
const resetSelectedMap = () => {
    props.selectedMap = '';
    Inertia.get(route('sharespots.index', { selectedCharacter: props.selectedCharacter, selectedTag: props.selectedTag, category: props.selectedCategory }));
};

// キャラクターの絞り込みを解除する
const resetSelectedCharacter = () => {
    props.selectedCharacter = '';
    Inertia.get(route('sharespots.index', { selectedMap: props.selectedMap, selectedTag: props.selectedTag, category: props.selectedCategory }));
};

// カテゴリーの絞り込みを解除する
const resetSelectedCategory = () => {
    props.selectedCategory = '';
    Inertia.get(route('sharespots.index', { selectedMap: props.selectedMap, selectedCharacter: props.selectedCharacter, selectedTag: props.selectedTag }));
};

const search = ref('');

const searchSpots = () => {
    Inertia.get(route('sharespots.index', { search: search.value }));
};

const resetSpots = () => {
    Inertia.get(route('sharespots.index'));
};
</script>

<template>
    <div class="flex">
        <div class="share-spot-search flex w-full">
            <!-- デスクトップ（モバイル以外） -->
            <v-row v-if="!isMobile">
                <v-col cols="6" class="flex">
                    <SpotFilter
                        :maps="props.maps"
                        :characters="props.characters"
                        :tags="props.tags"
                        :selectedTag="props.selectedTag"
                        :selectedMap="props.selectedMap"
                        :selectedCharacter="props.selectedCharacter"
                        :categories="props.categories"
                        :routeName="'sharespots.index'"
                    />
                    <div class="flex">
                        <div class="text-grey ml-3 mt-2">
                            <div>
                                マップ:
                                <v-chip v-if="selectedMap" color="light-blue-lighten-5" closable @click="resetSelectedMap">{{ selectedMap.name }}</v-chip>
                                <span v-else class="text-grey text-lg font-bold">無し</span>
                            </div>
                            <div>
                                キャラクター:
                                <v-chip v-if="selectedCharacter" class="mt-1" color="light-blue-lighten-5" closable @click="resetSelectedCharacter">{{ selectedCharacter.name }}</v-chip>
                                <span v-else class="text-grey text-lg font-bold">無し</span>
                            </div>
                        </div>
                        <div class="text-grey ml-10 mt-3">
                            <div>
                                タグ:
                                <v-chip v-if="selectedTag" color="light-blue-lighten-5" close closable @click="resetSelectedTag"> {{ selectedTag }} </v-chip>
                                <span v-else class="text-grey text-lg font-bold">無し</span>
                            </div>
                            <div>
                                カテゴリー:
                                <v-chip v-if="selectedCategory" class="mt-1" color="light-blue-lighten-5" closable @click="resetSelectedCategory">{{ selectedCategory.name }}</v-chip>
                                <span v-else class="text-grey text-lg font-bold">無し</span>
                            </div>
                        </div>
                    </div>
                </v-col>
                <v-col cols="6" class="flex">
                    <v-text-field data-test="search-input" id="name" label="検索" v-model="search" class="ml-5 text-white search-spots" @keyup.enter="searchSpots"></v-text-field>
                    <v-btn @click="searchSpots" class="search-button ml-5 mt-3">検索</v-btn>
                    <v-btn @click="resetSpots" class="mx-2 mt-3" color="red">リセット</v-btn>
                </v-col>
            </v-row>
            <!-- モバイル端末 -->
            <v-row v-if="isMobile" justify="center">
                <v-col cols="12" class="flex justify-between">
                    <SpotFilter
                        :maps="props.maps"
                        :characters="props.characters"
                        :tags="props.tags"
                        :selectedTag="props.selectedTag"
                        :selectedMap="props.selectedMap"
                        :selectedCharacter="props.selectedCharacter"
                        :categories="props.categories"
                        :routeName="'sharespots.index'"
                    />
                    <div>
                        <v-btn @click="searchSpots" class="search-button ml-5 mt-3">検索</v-btn>
                        <v-btn @click="resetSpots" class="mx-2 mt-3" color="red">リセット</v-btn>
                    </div>
                </v-col>
                <v-col cols="12">
                    <v-text-field data-test="search-input" id="name" label="検索" v-model="search" class="mx-4 text-white search-spots" @keyup.enter="searchSpots"></v-text-field>
                </v-col>
                <v-col cols="12" class="flex ml-10">
                    <div class="text-grey ml-3 mt-2">
                        <div>
                            マップ:
                            <v-chip v-if="selectedMap" color="light-blue-lighten-5" closable @click="resetSelectedMap">{{ selectedMap.name }}</v-chip>
                            <span v-else class="text-grey text-lg font-bold">無し</span>
                        </div>
                        <div>
                            キャラクター:
                            <v-chip v-if="selectedCharacter" class="mt-1" color="light-blue-lighten-5" closable @click="resetSelectedCharacter">{{ selectedCharacter.name }}</v-chip>
                            <span v-else class="text-grey text-lg font-bold">無し</span>
                        </div>
                    </div>
                    <div class="text-grey ml-10 mt-2">
                        <div>
                            タグ:
                            <v-chip v-if="selectedTag" color="light-blue-lighten-5" closable @click="resetSelectedTag"> {{ selectedTag }} </v-chip>
                            <span v-else class="text-grey text-lg font-bold">無し</span>
                        </div>
                        <div>
                            カテゴリー:
                            <v-chip v-if="selectedCategory" class="mt-1" color="light-blue-lighten-5" closable @click="resetSelectedCategory">{{ selectedCategory.name }}</v-chip>
                            <span v-else class="text-grey text-lg font-bold">無し</span>
                        </div>
                    </div>
                </v-col>
            </v-row>
        </div>
    </div>
    <v-divider></v-divider>
</template>

<style scoped>
input:focus {
    outline: none;
}
</style>
