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
    search: {
        type: String,
        required: false,
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
    flash: Object,
});

// props.searchがある場合はprops.searchの値を、ない場合は'すべての投稿'を表示
const pageTitle = props.search ? props.search : 'すべての投稿';
</script>

<template>
    <Head :title="pageTitle" />

    <v-app>
        <NavBar :pageTitle="pageTitle" />
        <v-main class="bg-zinc-900">
            <v-container fluid>
                <div class="bg-neutral-700 pt-5 pb-10 mt-2 rounded">
                    <ShareSpotHeader
                        :selectedTag="props.selectedTag"
                        :maps="props.maps"
                        :characters="props.characters"
                        :tags="props.tags"
                        :categories="props.categories"
                        :selectedMap="props.selectedMap"
                        :selectedCharacter="props.selectedCharacter"
                        :selectedCategory="props.selectedCategory"
                    />
                    <ShareSpotList
                        :selectedTag="props.selectedTag"
                        :spots="props.spots"
                        :categories="props.categories"
                        :allSpotsCount="props.allSpotsCount"
                        :spotsCount="props.spotsCount"
                        :userCategories="props.userCategories"
                        :selectedMap="props.selectedMap"
                        :selectedCharacter="props.selectedCharacter"
                        :flash="props.flash"
                    />
                </div>
            </v-container>
        </v-main>
    </v-app>
</template>
