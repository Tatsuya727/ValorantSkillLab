<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

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
});

const dialog = ref(false);

const tab = ref(null);

const selectedMap = ref(props.selectedMap);
const selectedCharacter = ref(props.selectedCharacter);
const selectedTag = ref(localStorage.getItem('selectedTag') || null);

const filterSpots = () => {
    Inertia.get(route(props.routeName), { selectedMap: selectedMap.value, selectedCharacter: selectedCharacter.value, tag: selectedTag.value });
};

const selectMap = (map) => {
    selectedMap.value = map;
    if (!selectedCharacter.value) {
        tab.value = 2;
    }
};

const selectCharacter = (character) => {
    selectedCharacter.value = character;
    if (!selectedTag.value) {
        tab.value = 3;
    }
};

const selectTags = (tag) => {
    selectedTag.value = tag.name;
    localStorage.setItem('selectedTag', tag.name);
};

const resetFilter = () => {
    selectedMap.value = null;
    selectedCharacter.value = null;
    selectedTag.value = null;
};
</script>

<template>
    <div class="text-center">
        <v-btn class="ml-5 mt-3" @click="dialog = true" color="primary">絞り込み</v-btn>

        <v-dialog v-model="dialog" width="1400px" height="auto" min-height="900px">
            <v-card>
                <v-row no-gutters>
                    <!-- 画像とタブのセクション -->
                    <v-col cols="9" class="border-r">
                        <v-tabs v-model="tab" color="deep-purple-accent-4" align-tabs="center">
                            <v-tab :value="1">マップ</v-tab>
                            <v-tab :value="2">キャラクター</v-tab>
                            <v-tab :value="3">タグ</v-tab>
                        </v-tabs>
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
                                    <div class="flex">
                                        <div v-for="tag in tags" :key="tag.id">
                                            <v-chip @click="selectTags(tag)" class="m-2" color="blue" close>{{ tag.name }}</v-chip>
                                        </div>
                                    </div>
                                </v-card-text>
                            </v-window-item>
                        </v-window>
                    </v-col>

                    <!-- ボタンのセクション -->
                    <v-col cols="3" class="items-center justify-center">
                        <div class="mt-10">
                            <v-autocomplete class="m-3" label="マップ" v-model="selectedMap" :items="maps" item-title="name" item-value="id" clearable variant="outlined"></v-autocomplete>
                            <v-autocomplete class="m-3" label="キャラクター" v-model="selectedCharacter" :items="characters" item-title="name" item-value="id" clearable variant="outlined">
                            </v-autocomplete>
                            <v-autocomplete class="m-3" label="タグ" v-model="selectedTag" :items="tags" item-title="name" item-value="name" clearable variant="outlined"></v-autocomplete>
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
    </div>
</template>
