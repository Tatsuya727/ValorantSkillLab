<script setup>
import ImageModal from '@/Components/original/ImageModal.vue';
import ShowMenu from '@/Components/original/ShowMenu.vue';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    spot: {
        type: Object,
        required: true,
    },
    userCategories: {
        type: Array,
        required: false,
    },
    routeName: {
        type: String,
        required: true,
    },
    flash: Object,
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

// ページがロードされるたびにローカルストレージから選択されたタグを読み込む
const selectedTag = ref(localStorage.getItem('selectedTag') || '');

// タグを選択するとそのタグのスポットのみ表示する
const filterSpotsByTag = (tag) => {
    selectedTag.value = tag;
    localStorage.setItem('selectedTag', tag);
    Inertia.get(route(props.routeName), { tag: tag });
};
</script>
<template>
    <div class="bg-neutral-700 mt-10 mx-5 pb-20 rounded">
        <ShowMenu :spot="spot" :userCategories="userCategories" :flash="flash" />
        <div class="text-center">
            <h1 class="font-bold text-4xl text-white">{{ spot.title }}</h1>
            <h2 class="text-xl text-white">{{ spot.description }}</h2>
            <!-- tagsのnameをすべて表示 -->
            <div class="flex justify-center my-5">
                <div v-for="(tag, index) in spot.tags" :key="index">
                    <v-chip color="light-blue-lighten-5" class="py-1 px-3 ml-4 bg-sky-300 text-cyan-800 rounded-full text-sm cursor-pointer" @click="filterSpotsByTag(tag.name)">{{ tag.name }}</v-chip>
                </div>
            </div>
        </div>
        <div class="flex flex-wrap space-4 mx-4">
            <div v-for="(image, index) in spot.images" :key="index" class="justify-center">
                <v-img
                    :width="465"
                    cover
                    class="object-cover cursor-pointer transform transition-all duration-200 ease-in-out hover:scale-105 hover:shadow-lg"
                    :src="image.image_path"
                    alt=""
                    @click="openImageModal(image)"
                    loading="lazy"
                ></v-img>
                <div v-if="image.description" class="border border-white p-2 text-white">{{ image.description }}</div>
                <div v-else class="border border-white p-2 text-white">説明なし</div>
            </div>
        </div>
    </div>
    <ImageModal :isOpen="imageModal.isOpen" :image="imageModal.image" :closeModal="closeImageModal" />
</template>
