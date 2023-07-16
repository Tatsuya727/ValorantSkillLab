<script setup>
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import NavBar from '@/Components/NavBar.vue';

const props = defineProps({
    spot: {
        type: Object,
        required: true,
    },
    maps: {
        type: Array,
        required: true,
    },
    characters: {
        type: Array,
        required: true,
    },
    errors: {
        type: Object,
        required: true,
    },
});

const form = reactive({
    title: props.spot.title,
    description: props.spot.description,
    map_id: props.spot.map_id,
    character_id: props.spot.character_id,
    images: props.spot.images,
});

const updateSpot = () => {
    const formData = new FormData();
    formData.append('title', form.title);
    formData.append('description', form.description);
    formData.append('map_id', form.map_id);
    formData.append('character_id', form.character_id);

    form.images.forEach((image, index) => {
        if (image.file) {
            formData.append(`images[${index}][image_path]`, image.file);
        }
        if (image.description) {
            formData.append(`images[${index}][description]`, image.description);
        }
    });

    Inertia.put(`/spots/${props.spot.id}`, formData);
};

const onFileChange = (e, image) => {
    image.file = e.target.files[0];
};

const addImageForm = () => {
    form.images.push({ image_path: null, description: null });
};

const removeImageForm = (index) => {
    form.images.splice(index, 1);
};
</script>

<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2 flex justify-center min-h-screen mt-15">
            <v-form @submit.prevent="updateSpot" class="w-full max-w-6xl">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="title" class="block text-sm font-medium text-gray-700">タイトル<span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="title"
                            v-model="form.title"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        />
                        <div v-if="errors.title" class="text-red-500">{{ errors.title }}</div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="map_id" class="block text-sm font-medium text-gray-700">マップ<span class="text-red-500">*</span></label>
                        <select
                            name="map_id"
                            v-model="form.map_id"
                            class="mt-2 block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                        >
                            <option v-for="map in maps" :value="map.id">{{ map.name }}</option>
                        </select>
                        <div v-if="errors.map_id" class="text-red-500">{{ errors.map_id }}</div>
                    </div>

                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="character_id" class="block text-sm font-medium text-gray-700">キャラクター<span class="text-red-500">*</span></label>
                        <select
                            name="character_id"
                            v-model="form.character_id"
                            class="mt-2 block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                        >
                            <option v-for="character in characters" :value="character.id">{{ character.name }}</option>
                        </select>
                        <div v-if="errors.character_id" class="text-red-500">{{ errors.character_id }}</div>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="description" class="block text-sm font-medium text-gray-700">説明<span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="description"
                            v-model="form.description"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        />
                    </div>
                </div>

                <button type="button" @click="addImageForm" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">画像を追加</button>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div v-for="(image, index) in form.images" :key="index" class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <div class="my-5">
                            <label class="mb-2 inline-block text-neutral-700 dark:text-neutral-200 font-bold" for="image_path">
                                {{ index === 0 ? '結果' : index === 1 ? 'ポジション' : '追加' + (index - 1) }}
                                <span v-if="index === 0 || index === 1" class="text-red-500">*</span>
                            </label>
                            <input
                                class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                                type="file"
                                name="image_path"
                                @change="(e) => onFileChange(e, image)"
                            />
                            <div v-if="errors.images && errors.images[index]" class="text-red-500">{{ errors.images[index].image_path }}</div>
                            <!-- 画像を選択するとプレビューを表示 -->
                            <img :src="image.image_path" v-if="image.image_path" class="mt-2 w-full h-auto" />
                            <button v-if="index >= 2" type="button" @click="removeImageForm(index)" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">削除</button>
                        </div>

                        <label for="description" class="block text-sm font-medium text-gray-700">説明</label>
                        <textarea
                            name="description"
                            v-model="image.description"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            rows="4"
                        ></textarea>
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    作成
                </button>
            </v-form>
        </v-main>
    </v-app>
</template>
