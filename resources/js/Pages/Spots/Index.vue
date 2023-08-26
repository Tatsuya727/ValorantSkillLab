<script setup>
import NavBar from '@/Components/original/NavBar.vue';
import SpotHeader from '@/Components/original/SpotHeader.vue';
import SpotList from '@/Components/original/SpotList.vue';
import { defineProps, ref } from 'vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    spots: {
        type: Array,
        required: true,
    },
    categories: {
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
    liked: {
        type: Boolean,
        required: false,
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
    userCategories: {
        type: Array,
        required: false,
    },
    flash: Object,
});

const pageTitle = props.selectedCategory ? props.selectedCategory.name : 'すべて表示';
</script>

<template>
    <Head :title="pageTitle" />

    <v-app id="inspire">
        <NavBar :pageTitle="pageTitle" />
        <v-main class="bg-zinc-900">
            <v-container fluid>
                <div class="bg-neutral-700 pt-5 pb-10 mt-2 rounded">
                    <SpotHeader
                        :maps="maps"
                        :characters="characters"
                        :tags="tags"
                        :selectedTag="selectedTag"
                        :selectedMap="selectedMap"
                        :selectedCharacter="selectedCharacter"
                        :selectedCategory="selectedCategory"
                        :categories="categories"
                    />

                    <SpotList
                        :user="user"
                        :spots="spots"
                        :categories="categories"
                        :selectedMap="selectedMap"
                        :selectedCharacter="selectedCharacter"
                        :selectedTag="selectedTag"
                        :selectedCategory="selectedCategory"
                        :liked="liked"
                        :userCategories="userCategories"
                        :flash="flash"
                    />
                </div>
            </v-container>
        </v-main>
    </v-app>
</template>
