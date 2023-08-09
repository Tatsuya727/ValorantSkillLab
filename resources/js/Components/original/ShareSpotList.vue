<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    spots: {
        type: Array,
        required: true,
    },
    category: {
        type: Object,
        required: true,
    },
    showCategory: {
        type: Object,
        required: true,
    },
    selectedTag: {
        type: String,
        required: false,
    },
    // mapId: {
    //     type: Number,
    //     required: false,
    // },
    // characterId: {
    //     type: Number,
    //     required: false,
    // },
});

const selectedTag = ref(localStorage.getItem('selectedTag') || '');

// Spotの削除
const setDeleteSpotId = (id) => {
    deleteSpotId.value = id;
    deleteSpotDialog.value = true;
};

// Spotの削除
const deleteSpot = () => {
    Inertia.delete(route('spots.destroy', { spot: deleteSpotId.value }), {
        onSuccess: () => {
            deleteSpotDialog.value = false;
        },
    });
};

// タグを選択するとそのタグのスポットのみ表示する
const filterSpotsByTag = (tag) => {
    selectedTag.value = tag;
    localStorage.setItem('selectedTag', tag);
    if (props.mapName && props.mapId && props.characterName && props.characterId) {
        Inertia.get(route('spots.index'), {
            tag: tag,
            mapName: props.mapName,
            mapId: props.mapId,
            characterName: props.characterName,
            characterId: props.characterId,
            selectedTag: selectedTag.value,
        });
    } else if (props.mapName && props.mapId) {
        Inertia.get(route('spots.index'), {
            tag: tag,
            mapName: props.mapName,
            mapId: props.mapId,
            selectedTag: selectedTag.value,
        });
    } else if (props.characterName && props.characterId) {
        Inertia.get(route('spots.index'), {
            tag: tag,
            characterName: props.characterName,
            characterId: props.characterId,
            selectedTag: selectedTag.value,
        });
    } else {
        Inertia.get(route('spots.index'), {
            tag: tag,
            selectedTag: selectedTag.value,
        });
    }
};

// カテゴリーの表示・非表示を切り替える
if (props.categories) {
    props.categories.forEach((category) => {
        showCategory[category.id] = true;
    });
}

const deleteSpotId = ref(null);

const deleteSpotDialog = ref(false);
</script>

<template></template>
