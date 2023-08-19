<script setup>
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    tags: {
        type: Array,
        required: true,
    },

    selectedMap: {
        type: Number,
        required: false,
    },
    selectedCharacter: {
        type: Number,
        required: false,
    },
    routeName: {
        type: String,
        required: true,
    },
});

const selectedTag = ref(localStorage.getItem('selectedTag') || '');

// ページを離れるときにローカルストレージから選択されたタグを削除する
window.addEventListener('beforeunload', () => {
    localStorage.removeItem('selectedTag');
});

// タグを選択するとそのタグのスポットのみ表示する
const filterSpotsByTag = (tag) => {
    selectedTag.value = tag;
    localStorage.setItem('selectedTag', tag);
    if (props.selectedMap || props.selectedCharacter || selectedTag.value) {
        Inertia.get(route(props.routeName), { selectedMap: props.selectedMap, selectedCharacter: props.selectedCharacter, tag: selectedTag.value });
    } else {
        Inertia.get(route(props.routeName));
    }
};
</script>

<template>
    <div v-for="(tag, index) in tags" :key="index">
        <v-chip
            v-if="selectedTag && selectedTag === tag.name"
            :class="'cursor-pointer hover:bg-cyan-600 active:bg-indigo-500'"
            @click="filterSpotsByTag(tag.name)"
            class="ma-2"
            color="light-blue-lighten-4"
            label
        >
            {{ tag.name }}
        </v-chip>
        <v-chip v-else :class="'cursor-pointer hover:bg-cyan-900 active:bg-indigo-500'" @click="filterSpotsByTag(tag.name)" class="ma-2" color="indigo-accent-4 " label>
            {{ tag.name }}
        </v-chip>
    </div>
</template>
