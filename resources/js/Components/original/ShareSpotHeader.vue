<script setup>
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

import SpotFilter from '@/Components/original/SpotFilter.vue';

const props = defineProps({
    selectedTag: String,
    resetSelectedTag: Function,
    maps: Array,
    characters: Array,
    tags: Array,
    categories: Array,
    selectedMap: Array,
    selectedCharacter: Array,
    selectedCategory: Array,
});

const selectedTag = ref(localStorage.getItem('selectedTag') || '');

// ページを離れるときにローカルストレージから選択されたタグを削除する
window.addEventListener('beforeunload', () => {
    selectedTag.value = '';
    localStorage.removeItem('selectedTag');
});

// 画面上部に表示されたタグをクリックすると、タグの絞り込みを解除する
const resetSelectedTag = () => {
    selectedTag.value = '';
    localStorage.removeItem('selectedTag');

    // 選択したマップとキャラクターがあれば、それらを含めて絞り込みを行う
    if (props.selectedMap && props.selectedCharacter) {
        Inertia.get(route('sharespots.index'), { selectedMap: props.selectedMap, selectedCharacter: props.selectedCharacter });
    } else {
        Inertia.get(route('sharespots.index'));
    }
};

const search = ref('');

const searchSpots = () => {
    Inertia.get(route('sharespots.index', { search: search.value }));
};

const resetSpots = () => {
    selectedTag.value = '';
    localStorage.removeItem('selectedTag');

    search.value = '';
    Inertia.get(route('sharespots.index'));
};
</script>

<template>
    <div class="flex">
        <div class="share-spot-search flex w-full">
            <v-row>
                <v-col cols="4" class="flex">
                    <SpotFilter
                        :maps="props.maps"
                        :characters="props.characters"
                        :tags="props.tags"
                        :selectedMap="props.selectedMap"
                        :selectedCharacter="props.selectedCharacter"
                        :categories="props.categories"
                        :routeName="'sharespots.index'"
                    />
                    <div class="text-grey ml-3 mt-2">
                        <div>
                            選択したマップ:
                            <span v-if="selectedMap" class="text-green text-lg font-bold">{{ selectedMap.name }}</span>
                            <span v-else class="text-grey text-lg font-bold">無し</span>
                        </div>
                        <div>
                            選択したキャラクター:
                            <span v-if="selectedCharacter" class="text-green text-lg font-bold">{{ selectedCharacter.name }}</span>
                            <span v-else class="text-grey text-lg font-bold">無し</span>
                        </div>
                    </div>
                    <div class="text-grey ml-10 mt-3">
                        選択したタグ:
                        <v-chip v-if="selectedTag" color="light-blue-lighten-5" close closable @click="resetSelectedTag"> {{ selectedTag }} </v-chip>
                        <span v-else class="text-grey text-lg font-bold">無し</span>
                        <div>
                            選択したカテゴリー:
                            <span v-if="selectedCategory" class="text-green text-lg font-bold">{{ selectedCategory.name }}</span>
                            <span v-else class="text-grey text-lg font-bold">無し</span>
                        </div>
                    </div>
                </v-col>
                <v-col cols="8" class="flex">
                    <v-text-field data-test="search-input" id="name" label="検索" v-model="search" class="ml-5 text-white search-spots" @keyup.enter="searchSpots"></v-text-field>
                    <v-btn @click="searchSpots" class="search-button ml-5 mt-3">検索</v-btn>
                    <v-btn @click="resetSpots" class="mx-2 mt-3" color="red">リセット</v-btn>
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
