<script setup>
import NavBar from '@/Components/original/NavBar.vue';
import ShareSpotList from '@/Components/original/ShareSpotList.vue';
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
});

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
        Inertia.get(route('sharespots.index'), {
            mapId: props.mapId,
            characterId: props.characterId,
        });
    } else if (props.mapId) {
        Inertia.get(route('sharespots.index'), {
            mapId: props.mapId,
        });
    } else if (props.characterId) {
        Inertia.get(route('sharespots.index'), {
            characterId: props.characterId,
        });
    } else {
        Inertia.get(route('sharespots.index'));
    }
};
</script>

<template>
    <v-app>
        <NavBar />
        <v-main class="bg-zinc-900">
            <v-container fluid>
                <div class="bg-neutral-700 pt-5 pb-10 mt-2 rounded">
                    <div class="text-white">
                        タグ:
                        <v-chip v-if="selectedTag" color="light-blue-lighten-5" close closable @click="resetSelectedTag"> {{ selectedTag }} </v-chip>
                    </div>
                    <ShareSpotList :selectedTag="selectedTag" :spots="props.spots" :category="category" />
                </div>
            </v-container>
        </v-main>
    </v-app>
</template>
