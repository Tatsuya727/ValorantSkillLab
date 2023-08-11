<script setup>
import NavBar from '@/Components/original/NavBar.vue';
import ShareSpotList from '@/Components/original/ShareSpotList.vue';
import ShareSpotHeader from '@/Components/original/ShareSpotHeader.vue';
import { defineProps, ref } from 'vue';

const props = defineProps({
    spots: {
        type: Array,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
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
    allSpotsCount: {
        type: Number,
        required: true,
    },
    spotsCount: {
        type: Number,
        required: true,
    },
});

// ページがロードされるたびにローカルストレージから選択されたタグを読み込む
const selectedTag = ref(localStorage.getItem('selectedTag') || '');

// ページを離れるときにローカルストレージから選択されたタグを削除する
window.addEventListener('beforeunload', () => {
    localStorage.removeItem('selectedTag');
});
</script>

<template>
    <v-app>
        <NavBar />
        <v-main class="bg-zinc-900">
            <v-container fluid>
                <div class="bg-neutral-700 pt-5 pb-10 mt-2 rounded">
                    <ShareSpotHeader :selectedTag="selectedTag" />
                    <ShareSpotList :selectedTag="selectedTag" :spots="props.spots" :categories="props.categories" :allSpotsCount="props.allSpotsCount" :spotsCount="props.spotsCount" />
                </div>
            </v-container>
        </v-main>
    </v-app>
</template>
