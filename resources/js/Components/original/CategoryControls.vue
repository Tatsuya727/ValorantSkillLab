<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    categories: Array,
    showCategory: Object,
});

// すべてのカテゴリーを開く
const openAllCategory = () => {
    props.categories.forEach((category) => {
        props.showCategory[category.id] = true;
    });
};

// すべてのカテゴリーを閉じる
const closeAllCategory = () => {
    props.categories.forEach((category) => {
        props.showCategory[category.id] = false;
    });
};
</script>

<template>
    <v-btn color="primary" class="mr-3 open-all" @click="openAllCategory">すべて開く</v-btn>
    <v-btn color="secondary" class="close-all" @click="closeAllCategory">すべて閉じる</v-btn>
</template>
