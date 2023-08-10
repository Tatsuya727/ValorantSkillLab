<script setup>
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    selectedTag: String,
    resetSelectedTag: Function,
});

const selectedTag = ref(props.selectedTag);

// 画面上部に表示されたタグをクリックすると、タグの絞り込みを解除する
const resetSelectedTag = () => {
    selectedTag.value = '';
    localStorage.removeItem('selectedTag');
    Inertia.get(route('sharespots.index'));
    // if (props.mapId && props.characterId) {
    //     Inertia.get(route('sharespots.index'), {
    //         mapId: props.mapId,
    //         characterId: props.characterId,
    //     });
    // } else if (props.mapId) {
    //     Inertia.get(route('sharespots.index'), {
    //         mapId: props.mapId,
    //     });
    // } else if (props.characterId) {
    //     Inertia.get(route('sharespots.index'), {
    //         characterId: props.characterId,
    //     });
    // } else {
    //     Inertia.get(route('sharespots.index'));
    // }
};

const search = ref('');

const searchSpots = () => {
    Inertia.get(route('sharespots.index', { search: search.value }));
};
</script>

<template>
    <div class="flex">
        <div class="share-spot-search flex w-1/3">
            <v-btn class="ml-5 mt-3" height="45" color="danger">絞り込み</v-btn>
            <v-text-field data-test="search-input" id="name" label="検索" v-model="search" class="ml-5 text-white search-spots" variant="outlined"></v-text-field>
            <v-btn @click="searchSpots" class="search-button">検索</v-btn>
        </div>
        <div v-if="selectedTag" class="text-white ml-10">
            タグ:
            <v-chip color="light-blue-lighten-5" close closable @click="resetSelectedTag"> {{ selectedTag }} </v-chip>
        </div>
    </div>
</template>

<style scoped>
input:focus {
    outline: none;
}
</style>