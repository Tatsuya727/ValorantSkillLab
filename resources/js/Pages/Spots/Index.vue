<script setup>
import NavBar from '@/Components/original/NavBar.vue';
import FlashMessage from '@/Components/original/FlashMessage.vue';
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
        type: Number,
        required: false,
    },
    selectedCharacter: {
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
    flash: Object,
});

// フラッシュメッセージをコンソールに出力する
onMounted(() => {
    console.log(props.flash);
});

const showCategory = reactive({});

const selectedTag = ref(localStorage.getItem('selectedTag') || '');

// ページを離れるときにローカルストレージから選択されたタグを削除する
window.addEventListener('beforeunload', () => {
    selectedTag.value = '';
    localStorage.removeItem('selectedTag');
});

// // カテゴリーの表示・非表示を切り替える
// if (props.categories) {
//     props.categories.forEach((category) => {
//         showCategory[category.id] = true;
//     });
// }
</script>

<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-zinc-900">
            <v-container fluid>
                <div class="bg-neutral-700 pt-5 pb-10 mt-2 rounded">
                    <FlashMessage :flash="flash" />
                    <!-- <div v-if="$page.props.flash" class="alert alert-success">{{ $page.props.flash.message }}</div> -->
                    <SpotHeader
                        :maps="maps"
                        :characters="characters"
                        :tags="tags"
                        :selectedMap="selectedMap"
                        :selectedCharacter="selectedCharacter"
                        :showCategory="showCategory"
                        :categories="categories"
                    />

                    <v-row justify="start" v-if="props.spots" class="mx-15">
                        <!-- <template v-for="(category, index) in props.categories" :key="category.id"> -->
                        <!-- spot -->

                        <SpotList
                            :selectedTag="selectedTag"
                            :showCategory="showCategory"
                            :spots="spots"
                            :categories="categories"
                            :selectedMap="selectedMap"
                            :selectedCharacter="selectedCharacter"
                            :toggleCategory="toggleCategory"
                            :openUpdateDialog="openUpdateDialog"
                            :deleteCategory="deleteCategory"
                        />
                        <!-- </template> -->
                    </v-row>
                </div>
            </v-container>
        </v-main>
    </v-app>
</template>
