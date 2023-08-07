<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    selectedTag: String,
    mapId: Number,
    characterId: Number,
    tags: Array,
    maps: Array,
    characters: Array,
});

const selectedTag = ref(props.selectedTag);

const filterDialog = ref(false);

const openFilterDialog = () => {
    filterDialog.value = true;
};

const selectedMap = ref(props.mapId);
const selectedCharacter = ref(props.characterId);

const selectTag = (tagName) => {
    selectedTag.value = tagName;
    localStorage.setItem('selectedTag', tagName);
};

const filterSpots = () => {
    Inertia.get(route('spots.index'), { mapId: selectedMap.value, characterId: selectedCharacter.value, tag: selectedTag.value });
};

const resetSpots = () => {
    selectedTag.value = '';
    localStorage.removeItem('selectedTag');
    Inertia.get(route('spots.index'));
};
const toggle = ref(null);
</script>

<template>
    <div class="mt-6">
        <v-btn @click="openFilterDialog" class="mr-3">絞り込み</v-btn>
        <v-btn @click="resetSpots">リセット</v-btn>
    </div>
    <v-dialog v-model="filterDialog" max-width="800px">
        <v-card>
            <v-col col="2">
                <div>
                    <label for="map-select" class="mr-2">マップ</label>
                    <select
                        id="map-select"
                        v-model="selectedMap"
                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                    >
                        <option v-for="map in maps" :key="map.id" :value="map.id">{{ map.name }}</option>
                    </select>
                </div>
            </v-col>
            <v-col col="2">
                <div>
                    <label for="character-select" class="mr-2">キャラクター</label>
                    <select
                        id="character-select"
                        v-model="selectedCharacter"
                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                    >
                        <option v-for="character in characters" :key="character.id" :value="character.id">{{ character.name }}</option>
                    </select>
                </div>
            </v-col>
            <div class="flex flex-wrap m-3">
                <v-btn-toggle v-model="toggle" divided v-for="(tag, index) in tags" :key="index">
                    <v-btn
                        color="indigo-darken-4

"
                        :value="tag.name"
                        @click="selectTag(tag.name)"
                        class="mr-2 mb-2 border"
                        >{{ tag.name }}</v-btn
                    >
                </v-btn-toggle>
                <!-- <div
                    v-for="(tag, index) in tags"
                    :key="index"
                    :class="{
                        'border-2 border-cyan-500 rounded-lg px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 cursor-pointer hover:text-white hover:bg-cyan-500': selectedTag.value !== tag.name,
                        'bg-cyan-500 text-white': selectedTag.value === tag.name,
                    }"
                    @click="selectTag(tag.name)"
                    style="flex: 0 0 auto"
                >
                    <div>{{ tag.name }}</div>
                </div> -->
            </div>
            <v-btn color="success" block @click="filterSpots">検索</v-btn>
            <v-card-actions>
                <v-btn type="button" color="primary" block @click="filterDialog = false">閉じる</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
