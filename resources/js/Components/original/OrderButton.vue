<script setup>
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    selectedMap: {
        type: Object,
        required: false,
    },
    selectedCharacter: {
        type: Object,
        required: false,
    },
    selectedTag: {
        type: Object,
        required: false,
    },
    search: {
        type: String,
        required: false,
    },
    orderBy: {
        type: String,
        required: false,
    },
    routeName: {
        type: String,
        required: true,
    },
});

const orderBy = ref('');

const handleOrderBy = (item) => {
    orderBy.value = item;
    Inertia.get(route(props.routeName, { orderBy: orderBy.value, selectedMap: props.selectedMap, selectedCharacter: props.selectedCharacter, selectedTag: props.selectedTag, search: props.search }));
};

const orderItems = [
    {
        title: 'デフォルト',
        value: 'created_at',
    },
    {
        title: 'いいねの数(多い順)',
        value: 'likes',
    },
    {
        title: '作成日(古い順)',
        value: 'created_at, desc',
    },
    {
        title: '保存された数(多い順)',
        value: 'categories',
    },
];

console.log(props.orderBy);
</script>
<template>
    <v-menu>
        <template v-slot:activator="{ props }">
            <v-btn color="" v-bind="props"><v-icon>mdi-sort-variant</v-icon>並べ替え</v-btn>
        </template>
        <v-list>
            <v-list-item v-for="(orderItem, index) in orderItems" :key="index" :value="index">
                <v-list-item-title @click="handleOrderBy(orderItem.value)">
                    <v-icon v-if="props.orderBy === orderItem.value" class="mr-1">mdi-check</v-icon>
                    <v-icon v-else class="mr-1" style="opacity: 0">mdi-check</v-icon>
                    <span class="order-btn">{{ orderItem.title }}</span>
                </v-list-item-title>
            </v-list-item>
        </v-list>
    </v-menu>
</template>
