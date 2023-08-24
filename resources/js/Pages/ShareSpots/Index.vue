<script setup>
import NavBar from '@/Components/original/NavBar.vue';
import ShareSpotList from '@/Components/original/ShareSpotList.vue';
import ShareSpotHeader from '@/Components/original/ShareSpotHeader.vue';

import { Head } from '@inertiajs/vue3';

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
    userCategories: {
        type: Array,
        required: false,
    },
    selectedMap: {
        type: Array,
        required: false,
    },
    selectedCharacter: {
        type: Array,
        required: false,
    },
    selectedCategory: {
        type: Array,
        required: false,
    },
    flash: Object,
});

const pageTitle = 'みんなの投稿';
</script>

<template>
    <Head :title="pageTitle" />

    <v-app>
        <NavBar />
        <v-main class="bg-zinc-900">
            <v-container fluid>
                <div class="bg-neutral-700 pt-5 pb-10 mt-2 rounded">
                    <ShareSpotHeader
                        :selectedTag="selectedTag"
                        :maps="maps"
                        :characters="characters"
                        :tags="tags"
                        :categories="categories"
                        :selectedMap="selectedMap"
                        :selectedCharacter="selectedCharacter"
                        :selectedCategory="selectedCategory"
                    />
                    <ShareSpotList
                        :selectedTag="selectedTag"
                        :spots="props.spots"
                        :categories="props.categories"
                        :allSpotsCount="props.allSpotsCount"
                        :spotsCount="props.spotsCount"
                        :userCategories="userCategories"
                        :selectedMap="selectedMap"
                        :selectedCharacter="selectedCharacter"
                        :flash="flash"
                    />
                </div>
            </v-container>
        </v-main>
    </v-app>
</template>
