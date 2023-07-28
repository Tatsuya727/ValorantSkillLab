<script setup>
import NavBar from '@/Components/NavBar.vue';
import ImageModal from '@/Components/ImageModal.vue';
import { defineProps, ref } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

// import draggable from 'vuedraggable';

const props = defineProps({
    spot: {
        type: Object,
        required: true,
    },
});

const imageModal = ref({
    isOpen: false,
    image: null,
});

const openImageModal = (image) => {
    imageModal.value.isOpen = true;
    imageModal.value.image = image;
};

const closeImageModal = () => {
    imageModal.value.isOpen = false;
    imageModal.value.image = null;
};

const deleteSpot = (id) => {
    Inertia.delete(route('spots.destroy', { spot: id }));
};

const dialog = ref(false);

// ページがロードされるたびにローカルストレージから選択されたタグを読み込む
const selectedTag = ref(localStorage.getItem('selectedTag') || '');

// タグを選択するとそのタグのスポットのみ表示する
const filterSpotsByTag = (tag) => {
    selectedTag.value = tag;
    localStorage.setItem('selectedTag', tag);
    Inertia.get(route('spots.index'), { tag: tag });
};
</script>
<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2">
            <div class="text-right mt-5 mr-5">
                <v-menu>
                    <template v-slot:activator="{ props }">
                        <v-btn icon="mdi-dots-horizontal" v-bind="props"></v-btn>
                    </template>

                    <v-list>
                        <v-list-item>
                            <Link :href="`/spots/${spot.id}/edit`">
                                <v-list-item-title><v-icon>mdi-pencil</v-icon>編集する(作成中)</v-list-item-title>
                            </Link>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title @click="dialog = true" class="cursor-pointer"><v-icon>mdi-trash-can-outline</v-icon>削除する</v-list-item-title>
                            <!-- <v-list-item-title @click="deleteSpot(spot.id)" class="cursor-pointer">削除する</v-list-item-title> -->
                        </v-list-item>
                    </v-list>
                </v-menu>
                <!-- 削除ボタンの確認ダイアログ -->
                <v-dialog v-model="dialog" width="auto">
                    <v-card>
                        <v-card-text class="font-bold">本当に削除しますか？</v-card-text>
                        <v-card-actions>
                            <v-btn variant="outlined" color="error" block @click="deleteSpot(spot.id)">削除する</v-btn>
                        </v-card-actions>
                        <v-card-actions>
                            <v-btn variant="outlined" color="primary" block @click="dialog = false">キャンセル</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </div>
            <div class="text-center">
                <h1 class="font-bold text-4xl">{{ spot.title }}</h1>
                <h2 class="text-xl">{{ spot.description }}</h2>
                <!-- tagsのnameをすべて表示 -->
                <div class="flex justify-center mb-5">
                    <div v-for="(tag, index) in spot.tags" :key="index">
                        <div class="py-1 px-3 ml-4 bg-sky-300 text-cyan-800 rounded-full text-sm cursor-pointer" @click="filterSpotsByTag(tag.name)">{{ tag.name }}</div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap space-4 mx-4">
                <div v-for="(image, index) in spot.images" :key="index" class="justify-center">
                    <v-img :width="465" cover class="object-cover cursor-pointer" :src="image.image_path" alt="" @click="openImageModal(image)"></v-img>
                    <div v-if="image.description" class="border p-2 text-gray-500">{{ image.description }}</div>
                    <div v-else class="border p-2 text-gray-500">説明なし</div>
                </div>
            </div>
            <ImageModal :isOpen="imageModal.isOpen" :image="imageModal.image" :closeModal="closeImageModal" />
        </v-main>
    </v-app>
</template>
