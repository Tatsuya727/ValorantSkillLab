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

const selectedTag = ref(localStorage.getItem('selectedTag') || '');

// ページを離れるときにローカルストレージから選択されたタグを削除する
window.addEventListener('beforeunload', () => {
    selectedTag.value = '';
    localStorage.removeItem('selectedTag');
});

const pageTitle = props.selectedCategory ? props.selectedCategory.name : '全て';
</script>

<template>
    <Head :title="pageTitle" />

    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-zinc-900">
            <v-container fluid>
                <div class="bg-neutral-700 pt-5 pb-10 mt-2 rounded">
                    <SpotHeader
                        :maps="maps"
                        :characters="characters"
                        :tags="tags"
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
                        :userCategories="userCategories"
                        :flash="flash"
                    />
                </div>
            </v-container>
        </v-main>
    </v-app>
</template>
