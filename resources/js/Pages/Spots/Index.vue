<script setup>
import NavBar from '@/Components/original/NavBar.vue';
import SpotHeader from '@/Components/original/SpotHeader.vue';
import SpotList from '@/Components/original/SpotList.vue';
import { defineProps, onMounted, reactive, ref } from 'vue';

const props = defineProps({
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
        type: Number,
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
</script>

<template>
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
                        :selectedTag="selectedTag"
                        :spots="spots"
                        :categories="categories"
                        :selectedMap="selectedMap"
                        :selectedCharacter="selectedCharacter"
                        :selectedCategory="selectedCategory"
                        :openUpdateDialog="openUpdateDialog"
                        :deleteCategory="deleteCategory"
                        :userCategories="userCategories"
                        :flash="flash"
                    />
                </div>
            </v-container>
        </v-main>
    </v-app>
</template>
