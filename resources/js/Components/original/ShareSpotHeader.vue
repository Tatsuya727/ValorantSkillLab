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
</script>

<template>
    <div class="flex">
        <div class="share-spot-search flex w-1/3">
            <v-btn class="ml-5 mt-3" height="45" color="danger">絞り込み</v-btn>
            <v-text-field class="ml-5 text-white" label="検索" variant="outlined"></v-text-field>
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
