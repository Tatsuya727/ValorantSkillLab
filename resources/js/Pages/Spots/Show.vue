<script setup>
import NavBar from '@/Components/NavBar.vue';
import ImageModal from '@/Components/ImageModal.vue';
import { defineProps, ref } from 'vue';

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
</script>
<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2">
            <div>
                <h1 class="font-bold">{{ spot.title }}</h1>
                <h2>{{ spot.description }}</h2>
                <div class="flex flex-wrap space-4">
                    <div v-for="(image, index) in spot.images" :key="index" class="w-1/4">
                        <img class="object-cover cursor-pointer" :src="image.image_path" alt="" @click="openImageModal(image.image_path)" />
                    </div>
                </div>
            </div>
            <ImageModal :isOpen="imageModal.isOpen" :image="imageModal.image" :closeModal="closeImageModal" />
        </v-main>
    </v-app>
</template>
