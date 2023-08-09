<script setup>
import NavBar from '@/Components/original/NavBar.vue';
import ShareSpotList from '@/Components/original/ShareSpotList.vue';

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
</script>

<template>
    <v-app>
        <NavBar />
        <v-main class="bg-zinc-900">
            <v-container fluid>
                <div class="bg-neutral-700 pt-5 pb-10 mt-2 rounded">
                    <ShareSpotList :selectedTag="selectedTag" :spots="props.spots" :category="category" />
                </div>
            </v-container>
        </v-main>
    </v-app>
</template>
