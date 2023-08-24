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

// タグを選択するとそのタグのスポットのみ表示する
const filterSpotsByTag = (tag) => {
    props.selectedTag = tag;
    Inertia.get(route(props.routeName), { selectedTag: props.selectedTag });
};
</script>
<template>
    <div class="bg-neutral-700 mt-10 mx-5 pb-20 rounded">
        <ShowMenu :spot="spot" :userCategories="userCategories" :flash="flash" />
        <v-row justify="center">
            <v-col cols="12">
                <div class="text-center">
                    <h1 class="font-bold text-4xl text-white">{{ spot.title }}</h1>
                    <h2 class="text-xl text-white">{{ spot.description }}</h2>
                    <!-- tagsのnameをすべて表示 -->
                    <div class="flex justify-center my-5">
                        <div v-for="(tag, index) in spot.tags" :key="index">
                            <v-chip color="light-blue-lighten-5" class="py-1 px-3 ml-4 bg-sky-300 text-cyan-800 rounded-full text-sm cursor-pointer" @click="filterSpotsByTag(tag.name)">{{
                                tag.name
                            }}</v-chip>
                        </div>
                    </div>
                </div>
            </v-col>
            <v-col cols="12">
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
                        <div v-if="image.description" class="border border-white p-2 text-white max-w-full break-words" style="max-width: 465px">
                            {{ image.description }}
                        </div>
                        <div v-else class="border border-white p-2 text-white max-w-full break-words" style="max-width: 465px">説明なし</div>
                    </div>
                </div>
            </v-col>
        </v-row>
    </div>
    <ImageModal :isOpen="imageModal.isOpen" :image="imageModal.image" :closeModal="closeImageModal" />
</template>
