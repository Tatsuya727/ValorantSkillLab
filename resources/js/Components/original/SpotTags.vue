<script setup>
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    tags: {
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
    routeName: {
        type: String,
        required: true,
    },
});

const selectedTag = ref(props.selectedTag);

// タグを選択するとそのタグのスポットのみ表示する
const filterSpotsByTag = (tag) => {
    selectedTag.value = tag;
    if (props.selectedMap || props.selectedCharacter || props.selectedCategory || selectedTag.value) {
        Inertia.get(route(props.routeName), { selectedMap: props.selectedMap, selectedCharacter: props.selectedCharacter, category: props.selectedCategory, selectedTag: selectedTag.value });
    } else {
        Inertia.get(route(props.routeName));
    }
};
</script>

<template>
    <div v-for="(tag, index) in tags" :key="index">
        <v-chip
            v-if="selectedTag && selectedTag === tag.name"
            :class="'cursor-pointer hover:bg-cyan-600 active:bg-indigo-500 selected-tag '"
            @click="filterSpotsByTag(tag.name)"
            class="m-2"
            color="light-blue-lighten-4"
            label
        >
            {{ tag.name }}
        </v-chip>
        <v-chip v-else :class="'cursor-pointer hover:bg-cyan-900 active:bg-indigo-500 common-tag'" @click="filterSpotsByTag(tag.name)" class="ma-2 tag" color="indigo-accent-4 " label>
            {{ tag.name }}
        </v-chip>
    </div>
</template>
