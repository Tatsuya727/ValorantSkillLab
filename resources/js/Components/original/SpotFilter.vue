<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
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
    categories: {
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
    search: {
        type: String,
        required: false,
    },
    routeName: {
        type: String,
        required: true,
    },
});

const { isMobile } = useMobileDetection();

const dialog = ref(false);

const tab = ref(null);

const selectedMap = ref(props.selectedMap);
const selectedCharacter = ref(props.selectedCharacter);
const selectedTag = ref(props.selectedTag);
const selectedCategory = ref(props.selectedCategory);

const filterSpots = () => {
    Inertia.get(route(props.routeName), {
        selectedMap: selectedMap.value,
        selectedCharacter: selectedCharacter.value,
        selectedTag: selectedTag.value,
        category: selectedCategory.value,
        search: props.search,
    });
};

const selectMap = (map) => {
    selectedMap.value = map;
    tab.value = 2;
};

const selectCharacter = (character) => {
    selectedCharacter.value = character;
    tab.value = 3;
};

const selectTags = (tag) => {
    selectedTag.value = tag.name;
    tab.value = 4;
};

const selectCategory = (category) => {
    selectedCategory.value = category; // カテゴリーオブジェクト全体を設定
};

const resetFilter = () => {
    selectedMap.value = null;
    selectedCharacter.value = null;
    selectedTag.value = null;
    selectedCategory.value = null;
};

const panel = ref(0);
</script>

<template>
    <div class="text-center">
        <v-btn class="ml-5 mt-3 filtering-btn" @click="dialog = true" color="primary">絞り込み</v-btn>

        <!-- デスクトップ（モバイル以外） -->
        <v-dialog v-model="dialog" width="1400px" v-if="!isMobile">
            <v-card>
                <v-row no-gutters>
                    <!-- 画像とタブのセクション -->
                    <v-col cols="9" class="border-r">
                        <v-tabs v-model="tab" color="deep-purple-accent-4" align-tabs="center">
                            <v-tab :value="1">マップ</v-tab>
                            <v-tab :value="2">キャラクター</v-tab>
                            <v-tab :value="3">タグ</v-tab>
                            <v-tab :value="4">カテゴリー</v-tab>
                        </v-tabs>
                        <v-window v-model="tab">
                            <v-window-item :value="1">
                                <v-card-title class="text-center">マップを選択</v-card-title>
                                <v-card-text class="flex flex-wrap">
                                    <div v-for="map in maps" :key="map.id" class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/3 p-2">
                                        <v-img class="cursor-pointer map-img" @click="selectMap(map)" :width="400" cover :src="map.image_path" :alt="map.name" loading="lazy"></v-img>
                                    </div>
                                </v-card-text>
                            </v-window-item>
                            <v-window-item :value="2">
                                <v-card-title class="text-center">キャラクターを選択</v-card-title>
                                <v-card-text class="flex flex-wrap">
                                    <div v-for="character in characters" :key="character.id" class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 p-2 relative">
                                        <v-img class="cursor-pointer" @click="selectCharacter(character)" :width="300" cover :src="character.image_path" :alt="character.name" loading="lazy"></v-img>
                                        <div class="absolute bottom-2 left-2 bg-gradient-to-r from-black to-transparent text-white text-lg font-serif text-center font-bold rounded px-2 py-1">
                                            {{ character.name }}
                                        </div>
                                    </div>
                                </v-card-text>
                            </v-window-item>

                            <v-window-item :value="3">
                                <v-card-title class="text-center flex">
                                    <div>タグを選択</div>
                                </v-card-title>
                                <v-card-text class="mx-10 text-center">
                                    <!-- <v-autocomplete label="タグを検索" :items="tags" item-value="id" item-title="name" clearable chips variant="outlined"></v-autocomplete> -->
                                    <div class="flex flex-wrap">
                                        <div v-for="tag in tags" :key="tag.id">
                                            <v-chip @click="selectTags(tag)" class="m-2 whitespace-normal" color="blue" close>{{ tag.name }}</v-chip>
                                        </div>
                                    </div>
                                </v-card-text>
                            </v-window-item>
                            <v-window-item :value="4">
                                <v-card-title class="text-center flex">
                                    <div>カテゴリーを選択</div>
                                </v-card-title>
                                <v-card-text class="mx-10 text-center">
                                    <div class="flex flex-wrap">
                                        <div v-for="category in categories" :key="category.id">
                                            <v-chip @click="selectCategory(category)" class="m-2" color="blue" close>{{ category.name }}</v-chip>
                                        </div>
                                    </div>
                                </v-card-text>
                            </v-window-item>
                        </v-window>
                    </v-col>

                    <!-- ボタンのセクション -->
                    <v-col cols="3" class="items-center justify-center">
                        <div class="mt-10">
                            <v-autocomplete
                                class="m-3 map-select"
                                label="マップ"
                                v-model="selectedMap"
                                :items="maps"
                                item-title="name"
                                item-value="id"
                                clearable
                                variant="outlined"
                                return-object
                            ></v-autocomplete>
                            <v-autocomplete
                                class="m-3 character-select"
                                label="キャラクター"
                                v-model="selectedCharacter"
                                :items="characters"
                                item-title="name"
                                item-value="id"
                                clearable
                                variant="outlined"
                                return-object
                            >
                            </v-autocomplete>
                            <v-autocomplete class="m-3 tag-select" label="タグ" v-model="selectedTag" :items="tags" item-title="name" item-value="name" clearable variant="outlined"></v-autocomplete>
                            <v-autocomplete
                                class="m-3 category-select"
                                label="カテゴリー"
                                v-model="selectedCategory"
                                :items="categories"
                                item-title="name"
                                item-value="id"
                                clearable
                                variant="outlined"
                                return-object
                            ></v-autocomplete>
                        </div>

                        <v-btn color="success" block @click="filterSpots">検索</v-btn>
                        <!-- リセットボタン -->
                        <div class="flex justify-center my-5">
                            <v-btn class="mx-3" color="error" @click="resetFilter" variant="outlined">リセット</v-btn>
                            <v-btn class="mx-3" color="primary" @click="dialog = false" variant="outlined">閉じる</v-btn>
                        </div>
                    </v-col>
                </v-row>
            </v-card>
        </v-dialog>
        <!-- モバイル端末 -->
        <v-dialog v-model="dialog" v-if="isMobile">
            <v-card>
                <v-row no-gutters>
                    <v-tabs v-model="tab" color="deep-purple-accent-4" align-tabs="center" class="sticky">
                        <v-tab :value="1">マップ</v-tab>
                        <v-tab :value="2">キャラクター</v-tab>
                        <v-tab :value="3">タグ</v-tab>
                        <v-tab :value="4">カテゴリー</v-tab>
                    </v-tabs>
                    <!-- ボタンのセクション -->
                    <v-col cols="12" class="items-center justify-center">
                        <v-expansion-panels v-model="panel">
                            <v-expansion-panel>
                                <v-expansion-panel-title class="bg-grey mt-1">
                                    <div class="text-center">詳細</div>
                                </v-expansion-panel-title>
                                <v-expansion-panel-text>
                                    <v-col cols="12" class="items-center justify-center">
                                        <v-autocomplete
                                            class="m-3"
                                            label="マップ"
                                            v-model="selectedMap"
                                            :items="maps"
                                            item-title="name"
                                            item-value="id"
                                            clearable
                                            variant="outlined"
                                            return-object
                                        ></v-autocomplete>
                                        <v-autocomplete
                                            class="m-3"
                                            label="キャラクター"
                                            v-model="selectedCharacter"
                                            :items="characters"
                                            item-title="name"
                                            item-value="id"
                                            clearable
                                            variant="outlined"
                                            return-object
                                        >
                                        </v-autocomplete>
                                        <v-autocomplete class="m-3" label="タグ" v-model="selectedTag" :items="tags" item-title="name" item-value="name" clearable variant="outlined"></v-autocomplete>
                                        <v-autocomplete
                                            class="m-3"
                                            label="カテゴリー"
                                            v-model="selectedCategory"
                                            :items="categories"
                                            item-title="name"
                                            item-value="id"
                                            clearable
                                            variant="outlined"
                                            return-object
                                        ></v-autocomplete>
                                    </v-col>
                                </v-expansion-panel-text>
                            </v-expansion-panel>
                        </v-expansion-panels>

                        <v-btn color="success" class="mt-1" block @click="filterSpots">検索</v-btn>
                        <!-- リセットボタン -->
                        <div class="flex justify-center my-5">
                            <v-btn class="mx-3" color="error" @click="resetFilter" variant="outlined">リセット</v-btn>
                            <v-btn class="mx-3" color="primary" @click="dialog = false" variant="outlined">閉じる</v-btn>
                        </div>
                    </v-col>

                    <!-- 画像とタブのセクション -->
                    <v-col cols="12" class="border-r">
                        <v-window v-model="tab">
                            <v-window-item :value="1">
                                <v-card-title class="text-center">マップを選択</v-card-title>
                                <v-card-text class="flex flex-wrap">
                                    <div v-for="map in maps" :key="map.id" class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/3 p-2">
                                        <v-img class="cursor-pointer" @click="selectMap(map)" :width="400" cover :src="map.image_path" :alt="map.name" loading="lazy"></v-img>
                                    </div>
                                </v-card-text>
                            </v-window-item>
                            <v-window-item :value="2">
                                <v-card-title class="text-center">キャラクターを選択</v-card-title>
                                <v-card-text class="flex flex-wrap">
                                    <div v-for="character in characters" :key="character.id" class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/4 p-2 relative">
                                        <v-img class="cursor-pointer" @click="selectCharacter(character)" :width="300" cover :src="character.image_path" :alt="character.name" loading="lazy"></v-img>
                                        <div class="absolute bottom-2 left-2 bg-gradient-to-r from-black to-transparent text-white text-lg font-serif text-center font-bold rounded px-2 py-1">
                                            {{ character.name }}
                                        </div>
                                    </div>
                                </v-card-text>
                            </v-window-item>

                            <v-window-item :value="3">
                                <v-card-title class="text-center flex">
                                    <div>タグを選択</div>
                                </v-card-title>
                                <v-card-text class="mx-10 text-center">
                                    <!-- <v-autocomplete label="タグを検索" :items="tags" item-value="id" item-title="name" clearable chips variant="outlined"></v-autocomplete> -->
                                    <div class="">
                                        <div v-for="tag in tags" :key="tag.id">
                                            <v-chip @click="selectTags(tag)" class="m-2" color="blue" close>{{ tag.name }}</v-chip>
                                        </div>
                                    </div>
                                </v-card-text>
                            </v-window-item>
                            <v-window-item :value="4">
                                <v-card-title class="text-center flex">
                                    <div>カテゴリーを選択</div>
                                </v-card-title>
                                <v-card-text class="mx-10 text-center">
                                    <div class="flex">
                                        <div v-for="category in categories" :key="category.id">
                                            <v-chip @click="selectCategory(category)" class="m-2" color="blue" close>{{ category.name }}</v-chip>
                                        </div>
                                    </div>
                                </v-card-text>
                            </v-window-item>
                        </v-window>
                    </v-col>
                </v-row>
            </v-card>
        </v-dialog>
    </div>
</template>

<style scoped>
.sticky {
    position: sticky;
    top: 0;
    z-index: 99999;
    background-color: white;
}
</style>
