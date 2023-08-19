<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    selectedTag: String,
    selectedMap: Array,
    selectedCharacter: Array,
    tags: Array,
    maps: Array,
    characters: Array,
});

const selectedTag = ref(props.selectedTag);

const filterDialog = ref(false);

const openFilterDialog = () => {
    filterDialog.value = true;
};

const selectedMap = ref(props.selectedMap);
const selectedCharacter = ref(props.selectedCharacter);

const selectTag = (tagName) => {
    selectedTag.value = tagName;
    localStorage.setItem('selectedTag', tagName);
};

const filterSpots = () => {
    Inertia.get(route('spots.index'), { selectedMap: selectedMap.value, selectedCharacter: selectedCharacter.value, tag: selectedTag.value });
};

const resetSpots = () => {
    selectedTag.value = '';
    localStorage.removeItem('selectedTag');
    console.log(props.maps);
    Inertia.get(route('spots.index'));
};

const toggle = ref(null);

const resetFilter = () => {
    selectedMap.value = null;
    selectedCharacter.value = null;
    selectedTag.value = '';
    localStorage.removeItem('selectedTag');
    toggle.value = null;
};
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
                    <v-autocomplete label="マップ" v-model="selectedMap" :items="maps" item-title="name" item-value="id" variant="outlined"></v-autocomplete>
                </div>
            </v-col>
            <v-col col="2">
                <div>
                    <v-autocomplete label="キャラクター" v-model="selectedCharacter" :items="characters" item-title="name" item-value="id" variant="outlined"> </v-autocomplete>
                </div>
            </v-col>
            <div class="flex flex-wrap m-3">
                <v-row justify="center">
                    <v-btn-toggle v-model="toggle" divided v-for="(tag, index) in tags" :key="index">
                        <v-btn color="indigo-darken-4" :value="tag.name" @click="selectTag(tag.name)" class="mr-2 mb-2 border">{{ tag.name }}</v-btn>
                    </v-btn-toggle>
                </v-row>
            </div>
            <v-row justify="center">
                <v-col cols="5">
                    <v-btn color="success" block @click="filterSpots">検索</v-btn>
                </v-col>
                <v-col cols="5">
                    <v-btn type="button" color="primary" block @click="resetFilter">リセット</v-btn>
                </v-col>
            </v-row>
            <v-card-actions>
                <v-btn type="button" block @click="filterDialog = false">閉じる</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
