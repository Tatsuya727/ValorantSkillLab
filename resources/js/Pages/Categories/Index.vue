<script setup>
import NavBar from '@/Components/original/NavBar.vue';
import { defineProps, ref } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
    spots: {
        type: Array,
        required: true,
    },
});

const selectedCategory = ref(null);

// カテゴリーの名前をクリックすると、そのカテゴリーを持つspots.indexに遷移する
const selectCategory = (category) => {
    selectedCategory.value = category.id;
    Inertia.get(route('spots.index'), { category: selectedCategory.value });
};
</script>
<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-zinc-900">
            <v-container fluid>
                <div class="bg-neutral-700 pt-5 pb-10 mt-2 rounded">
                    <div v-for="category in props.categories" :key="category.id">
                        <div @click="selectCategory(category)" class="cursor-pointer">{{ category.name }}</div>
                    </div>
                </div>
            </v-container>
        </v-main>
    </v-app>
</template>
