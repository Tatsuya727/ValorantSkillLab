<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import NavBar from '@/Components/NavBar.vue';

const props = defineProps({
    maps: {
        type: Array,
        required: true,
    },
    characters: {
        type: Array,
        required: true,
    },
});

const form = ref({
    name: null,
    description: null,
    map_id: null,
    character_id: null,
    images: [
        { image_path: null, description: null },
        { image_path: null, description: null },
    ],
});

const storeSpot = () => {
    Inertia.post('/spots', form);
};
</script>

<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2 flex justify-center min-h-screen mt-15">
            <v-form @submit.prevent="storeSpot" class="w-full max-w-5xl">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="title" class="block text-sm font-medium text-gray-700">タイトル</label>
                        <input
                            type="text"
                            name="title"
                            v-model="form.title"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        />
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="map_id" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">マップ</label>
                        <select
                            name="map_id"
                            v-model="form.map_id"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        >
                            <option v-for="map in maps" :value="map.id">{{ map.name }}</option>
                        </select>
                    </div>

                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="character_id" class="block text-sm font-medium text-gray-700">キャラクター</label>
                        <select
                            name="character_id"
                            v-model="form.character_id"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        >
                            <option v-for="character in characters" :value="character.id">{{ character.name }}</option>
                        </select>
                    </div>
                </div>

                <label for="description" class="block text-sm font-medium text-gray-700">説明</label>
                <input
                    type="text"
                    name="description"
                    v-model="form.description"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                />

                <div div class="flex flex-wrap -mx-3 mb-6">
                    <div v-for="(image, index) in form.images" :key="index">
                        <div div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                            <label for="image_path" class="block text-sm font-medium text-gray-700">image_path</label>
                            <input
                                type="file"
                                name="image_path"
                                :v-model="image.image_path"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />
                            <label for="description" class="block text-sm font-medium text-gray-700">description</label>
                            <input
                                type="text"
                                name="description"
                                v-model="image.description"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            />
                        </div>
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
