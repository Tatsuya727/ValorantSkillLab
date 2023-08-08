<script setup>
import NavBar from '@/Components/original/NavBar.vue';
import StoreCategory from '@/Components/original/StoreCategory.vue';
import CategoryHeader from '@/Components/original/CategoryHeader.vue';
import CategoryControls from '@/Components/original/CategoryControls.vue';
import FilterControls from '@/Components/original/FilterControls.vue';
import SpotList from '@/Components/original/SpotList.vue';
import { defineProps, reactive, ref } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    spots: {
        type: Array,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    mapName: {
        type: String,
        required: false,
    },
    mapId: {
        type: Number,
        required: false,
    },
    characterName: {
        type: String,
        required: false,
    },
    characterId: {
        type: Number,
        required: false,
    },
    maps: {
        type: Array,
        required: false,
    },
    characters: {
        type: Array,
        required: false,
    },
    tags: {
        type: Array,
        required: false,
    },
});

const showCategory = reactive({});

// カテゴリーの表示・非表示を切り替える
if (props.categories) {
    props.categories.forEach((category) => {
        showCategory[category.id] = true;
    });
}

// ページがロードされるたびにローカルストレージから選択されたタグを読み込む
const selectedTag = ref(localStorage.getItem('selectedTag') || '');

// ページを離れるときにローカルストレージから選択されたタグを削除する
window.addEventListener('beforeunload', () => {
    localStorage.removeItem('selectedTag');
});

// 画面上部に表示されたタグをクリックすると、タグの絞り込みを解除する
const resetSelectedTag = () => {
    selectedTag.value = '';
    localStorage.removeItem('selectedTag');
    if (props.mapId && props.characterId) {
        Inertia.get(route('spots.index'), {
            mapId: props.mapId,
            characterId: props.characterId,
        });
    } else if (props.mapId) {
        Inertia.get(route('spots.index'), {
            mapId: props.mapId,
        });
    } else if (props.characterId) {
        Inertia.get(route('spots.index'), {
            characterId: props.characterId,
        });
    } else {
        Inertia.get(route('spots.index'));
    }
};
</script>

<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-zinc-900">
            <v-container fluid>
                <div class="bg-neutral-700 pt-5 pb-10 mt-2 rounded">
                    <v-row justify="center" class="mt-4">
                        <v-col cols="10">
                            <v-row>
                                <div class="w-full md:w-1/5">
                                    <CategoryControls :categories="categories" :showCategory="showCategory" />
                                </div>

                                <FilterControls :selectedTag="selectedTag" :maps="maps" :characters="characters" :tags="tags" :mapId="mapId" :characterId="characterId" />
                                <v-col col="2">
                                    <div>
                                        タグ:
                                        <v-chip v-if="selectedTag" color="light-blue-lighten-5" close closable @click="resetSelectedTag"> {{ selectedTag }} </v-chip>
                                    </div>
                                </v-col>
                                <v-col col="2">
                                    <div class="text-right">
                                        <StoreCategory />
                                    </div>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                    <v-row justify="start" v-if="props.spots" class="mx-15">
                        <template v-for="(category, index) in props.categories" :key="category.id">
                            <!-- カテゴリーヘッダー -->
                            <CategoryHeader :category="category" :showCategory="showCategory" :toggleCategory="toggleCategory" :openUpdateDialog="openUpdateDialog" :deleteCategory="deleteCategory" />
                            <!-- spot -->
                            <SpotList :selectedTag="selectedTag" :showCategory="showCategory" :spots="props.spots" :category="category" :mapId="props.mapId" :characterId="props.characterId" />
                        </template>
                    </v-row>
                </div>
            </v-container>
        </v-main>
    </v-app>
</template>
