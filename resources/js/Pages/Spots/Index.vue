<script setup>
import NavBar from '@/Components/original/NavBar.vue';
import StoreCategory from '@/Components/original/StoreCategory.vue';
import CategoryHeader from '@/Components/original/CategoryHeader.vue';
import CategoryControls from '@/Components/original/CategoryControls.vue';
import FilterControls from '@/Components/original/FilterControls.vue';
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

if (props.categories) {
    props.categories.forEach((category) => {
        showCategory[category.id] = true;
    });
}

const deleteSpotId = ref(null);

// Spotの削除
const setDeleteSpotId = (id) => {
    deleteSpotId.value = id;
    deleteSpotDialog.value = true;
};

// Spotの削除
const deleteSpot = () => {
    Inertia.delete(route('spots.destroy', { spot: deleteSpotId.value }), {
        onSuccess: () => {
            deleteSpotDialog.value = false;
        },
    });
};

// ページがロードされるたびにローカルストレージから選択されたタグを読み込む
const selectedTag = ref(localStorage.getItem('selectedTag') || '');

// タグを選択するとそのタグのスポットのみ表示する
const filterSpotsByTag = (tag) => {
    selectedTag.value = tag;
    localStorage.setItem('selectedTag', tag);
    if (props.mapName && props.mapId && props.characterName && props.characterId) {
        Inertia.get(route('spots.index'), {
            tag: tag,
            mapName: props.mapName,
            mapId: props.mapId,
            characterName: props.characterName,
            characterId: props.characterId,
            selectedTag: selectedTag.value,
        });
    } else {
        Inertia.get(route('spots.index'), {
            tag: tag,
        });
    }
};

// ページを離れるときにローカルストレージから選択されたタグを削除する
window.addEventListener('beforeunload', () => {
    localStorage.removeItem('selectedTag');
});

// 画面上部に表示されたタグをクリックすると、タグの絞り込みを解除する
const resetSelectedTag = () => {
    selectedTag.value = '';
    localStorage.removeItem('selectedTag');
    if (props.mapName && props.mapId && props.characterName && props.characterId) {
        Inertia.get(route('spots.index'), {
            mapName: props.mapName,
            mapId: props.mapId,
            characterName: props.characterName,
            characterId: props.characterId,
        });
    } else {
        Inertia.get(route('spots.index'));
    }
};

const deleteSpotDialog = ref(false);
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
                                        <v-chip v-if="selectedTag" color="primary" close @click="resetSelectedTag"> {{ selectedTag }} ✖ </v-chip>
                                    </div>
                                </v-col>
                                <v-col col="2">
                                    <StoreCategory />
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                    <v-row justify="start" v-if="props.spots" class="mx-15">
                        <template v-for="(category, index) in props.categories" :key="category.id">
                            <!-- カテゴリーヘッダー -->
                            <CategoryHeader :category="category" :showCategory="showCategory" :toggleCategory="toggleCategory" :openUpdateDialog="openUpdateDialog" :deleteCategory="deleteCategory" />
                            <!-- spot -->
                            <v-expand-transition>
                                <v-col cols="11" v-if="showCategory[category.id]">
                                    <div class="flex flex-wrap mx-auto gap-4">
                                        <v-slide-group selected-class="bg-success" show-arrows>
                                            <v-slide-group-item v-for="spot in props.spots" :key="spot.id">
                                                <div v-if="spot.category_id === category.id" class="flex flex-col items-center mb-4 bg-white rounded shadow mr-5">
                                                    <div v-if="(!props.mapId && !props.characterId) || (spot.map_id == props.mapId && spot.character_id == props.characterId)">
                                                        <!-- spot画像 -->
                                                        <Link :href="spot.show_url">
                                                            <img :width="300" cover class="rounded-t" :src="spot.images[0].image_path" alt="サムネイル画像" />
                                                        </Link>
                                                        <div class="p-2">
                                                            <!-- マップとキャラクター -->
                                                            <div class="flex justify-between">
                                                                <div>
                                                                    <p class="text-sm text-gray-700 mx-3">
                                                                        map: <span class="font-bold">{{ spot.map.name }}</span>
                                                                    </p>
                                                                    <p class="text-sm text-gray-700">
                                                                        character: <span class="font-bold">{{ spot.character.name }}</span>
                                                                    </p>
                                                                </div>
                                                                <v-menu>
                                                                    <template v-slot:activator="{ props }">
                                                                        <v-icon v-bind="props" class="ml-5 text-gray-600">mdi-dots-vertical</v-icon>
                                                                    </template>
                                                                    <v-list>
                                                                        <v-list-item>
                                                                            <v-list-item-title @click="setDeleteSpotId(spot.id)" class="cursor-pointer"
                                                                                ><v-icon>mdi-trash-can-outline</v-icon>削除する</v-list-item-title
                                                                            >
                                                                        </v-list-item>
                                                                    </v-list>
                                                                </v-menu>
                                                                <!-- Spot削除ボタンの確認ダイアログ -->
                                                                <v-dialog v-model="deleteSpotDialog" width="auto">
                                                                    <v-card>
                                                                        <v-card-text class="font-bold">本当に削除しますか？</v-card-text>
                                                                        <v-card-actions>
                                                                            <v-btn variant="outlined" color="error" block @click="deleteSpot(spot.id)">削除する</v-btn>
                                                                        </v-card-actions>
                                                                        <v-card-actions>
                                                                            <v-btn variant="outlined" color="primary" block @click="deleteSpotDialog = false">キャンセル</v-btn>
                                                                        </v-card-actions>
                                                                    </v-card>
                                                                </v-dialog>
                                                            </div>
                                                            <p class="text-sm text-gray-700 text-center">
                                                                title: <span class="font-bold">{{ spot.title }}</span>
                                                            </p>
                                                            <!-- タグの名前をすべて表示 -->
                                                            <div class="flex flex-wrap justify-center">
                                                                <div
                                                                    v-for="(tag, index) in spot.tags"
                                                                    :key="index"
                                                                    @click="filterSpotsByTag(tag.name)"
                                                                    :class="{
                                                                        'border-2 border-cyan-500 rounded-lg px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 cursor-pointer hover:text-white hover:bg-cyan-500':
                                                                            !selectedTag.value,
                                                                        'bg-cyan-500 text-white': selectedTag && selectedTag === tag.name,
                                                                    }"
                                                                >
                                                                    <div>{{ tag.name }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </v-slide-group-item>
                                        </v-slide-group>
                                    </div>
                                </v-col>
                            </v-expand-transition>
                        </template>
                    </v-row>
                </div>
            </v-container>
        </v-main>
    </v-app>
</template>
