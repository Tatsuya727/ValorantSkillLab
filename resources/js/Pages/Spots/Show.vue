<script setup>
import NavBar from '@/Components/NavBar.vue';
import ImageModal from '@/Components/ImageModal.vue';
import { defineProps, ref } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
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

const items = [{ title: '編集する' }, { title: '削除する' }];
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
                        <v-list-item v-for="(item, i) in items" :key="i">
                            <Link :href="item.title === '編集する' ? `/spots/${spot.id}/edit` : `/spots/${spot.id}/delete`">
                                <v-list-item-title>{{ item.title }}</v-list-item-title>
                            </Link>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </div>
            <div class="text-center">
                <h1 class="font-bold text-4xl">{{ spot.title }}</h1>
                <h2 class="text-xl">{{ spot.description }}</h2>
            </div>
            <div class="flex flex-wrap space-4 mx-4">
                <div v-for="(image, index) in spot.images" :key="index" class="justify-center">
                    <v-img :width="465" cover class="object-cover cursor-pointer" :src="image.image_path" alt="" @click="openImageModal(image)"></v-img>
                    <div class="border p-2 text-gray-500">{{ image.description }}</div>
                </div>
            </div>
            <ImageModal :isOpen="imageModal.isOpen" :image="imageModal.image" :closeModal="closeImageModal" />
        </v-main>
    </v-app>
</template>
