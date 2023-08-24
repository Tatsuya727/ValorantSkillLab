<script setup>
import { reactive, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import NavBar from '@/Components/original/NavBar.vue';
import StoreCategory from '@/Components/original/StoreCategory.vue';
import StoreTag from '@/Components/original/StoreTag.vue';
import { defineProps, computed, onMounted, onUnmounted } from 'vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    maps: {
        type: Array,
        required: true,
    },
    characters: {
        type: Array,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    tags: {
        type: Array,
        required: true,
    },
    errors: {
        type: Object,
        required: true,
    },
});

const form = reactive({
    title: '',
    description: '',
    map_id: '',
    character_id: '',
    categories: '',
    images: [
        { file: null, description: '', preview: null },
        { file: null, description: '', preview: null },
    ],
    tags: [],
});

const errors = reactive({
    title: null,
    description: null,
    map_id: null,
    character_id: null,
    categories: null,
    images: [],
    tags: null,
});

const storeSpot = () => {
    try {
        const formData = new FormData();
        formData.append('title', form.title);
        formData.append('description', form.description);
        formData.append('map_id', form.map_id);
        formData.append('character_id', form.character_id);
        formData.append('categories', form.categories);

        form.images.forEach((image, index) => {
            if (image.file) {
                formData.append(`images[${index}][image_path]`, image.file);
            }
            if (image.description) {
                formData.append(`images[${index}][description]`, image.description);
            }
        });

        form.tags.forEach((tagId, index) => {
            formData.append(`tags[${index}]`, tagId);
        });

        Inertia.post('/spots', formData, {
            onSuccess: () => {
                form.title = null;
                form.description = null;
                form.map_id = null;
                form.character_id = null;
                form.categories = null;
                form.images = [
                    { file: null, description: null, preview: null },
                    { file: null, description: null, preview: null },
                ];
                form.tags = [];
            },
            onError: (responseErrors) => {
                Object.assign(errors, responseErrors);
                console.log('onError');
                console.log(errors.images.image_path);
            },

            onFinish: () => {
                console.log('finish');
            },
        });
    } catch (error) {
        console.log('catch error');
        console.log(error);
    }
};

const selectedTag = ref(null);

const addTag = () => {
    if (selectedTag.value && !form.tags.includes(selectedTag.value.id)) {
        form.tags.push(selectedTag.value.id);
    }
    selectedTag.value = null;
};

const removeTag = (tag) => {
    form.tags = form.tags.filter((t) => t !== tag);
};

const onFileChange = (e, image) => {
    image.file = e.target.files[0];

    const reader = new FileReader();
    reader.onload = (e) => {
        image.preview = e.target.result;
    };
    reader.readAsDataURL(image.file);
};

const addImageForm = () => {
    form.images.push({ image_path: null, description: null });
};

const removeImageForm = (index) => {
    form.images.splice(index, 1);
};

const searchQuery = ref(''); // タグの検索クエリ
const filteredTags = computed(() => {
    return props.tags.filter((tag) => tag.name.toLowerCase().includes(searchQuery.value.toLowerCase()));
});

const showDropdown = ref(false); // ドロップダウンを表示するかどうかを制御するための変数

const handleClickOutside = (event) => {
    if (!dropdownRef.value.contains(event.target)) {
        showDropdown.value = false;
    }
};

const dropdownRef = ref(null); // ドロップダウンの参照

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});

const pageTitle = '作成する';
</script>

<template>
    <Head :title="pageTitle" />

    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-zinc-900 flex justify-center min-h-screen mt-10">
            <v-form @submit.prevent="storeSpot" class="w-full max-w-7xl bg-neutral-700 p-10 rounded">
                <!-- タイトル -->
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="title" class="block text-sm font-medium text-white">タイトル<span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="title"
                            v-model="form.title"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        />
                        <div v-if="errors.title" class="text-red-500">{{ errors.title }}</div>
                    </div>
                </div>

                <!-- マップ, カテゴリー, キャラ, タグ -->
                <div class="flex flex-wrap -mx-3 mb-6">
                    <!-- マップ -->
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="map_id" class="block text-sm font-medium text-white">マップ<span class="text-red-500">*</span></label>
                        <select
                            name="map_id"
                            v-model="form.map_id"
                            class="mt-2 block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                        >
                            <option disabled value="">マップを選択</option>
                            <option v-for="map in maps" :value="map.id">{{ map.name }}</option>
                        </select>
                        <div v-if="errors.map_id" class="text-red-500">{{ errors.map_id }}</div>
                    </div>

                    <!-- キャラクター -->
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label for="character_id" class="block text-sm font-medium text-white">キャラクター<span class="text-red-500">*</span></label>
                        <select
                            name="character_id"
                            v-model="form.character_id"
                            class="mt-2 block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                        >
                            <option disabled value="">キャラクターを選択</option>
                            <option v-for="character in characters" :value="character.id">{{ character.name }}</option>
                        </select>
                        <div v-if="errors.character_id" class="text-red-500">{{ errors.character_id }}</div>
                    </div>

                    <!-- カテゴリー -->
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label for="categories" class="block text-sm font-medium text-white">カテゴリー<span class="text-red-500">*</span></label>
                        <select
                            name="categories"
                            v-model="form.categories"
                            class="mt-2 block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                        >
                            <option disabled value="">カテゴリーを選択</option>
                            <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                        </select>
                        <div v-if="errors.categories" class="text-red-500">{{ errors.categories }}</div>
                        <div class="text-center mt-3">
                            <StoreCategory />
                        </div>
                    </div>

                    <!-- タグ -->
                    <div class="w-full md:w-2/3 px-3 mb-6 md:mb-0">
                        <div class="w-full px-3" ref="dropdownRef">
                            <div class="flex flex-wrap">
                                <label for="tags" class="block text-sm font-medium text-white">タグ<span>(3つまで選択可)</span></label>
                                <!-- 選択したタグを表示 -->
                                <div v-for="tagId in form.tags" :key="tagId" class="ml-2">
                                    <v-chip color="light-blue-lighten-5" close closable @click="removeTag(tagId)">
                                        {{ props.tags.find((tag) => tag.id === tagId).name }}
                                    </v-chip>
                                </div>
                            </div>
                            <input
                                type="text"
                                v-model="searchQuery"
                                @focus="showDropdown = true"
                                placeholder="タグを検索..."
                                class="mt-2 block w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
                            />
                            <ul v-if="filteredTags.length && showDropdown" class="dropdown-list">
                                <li
                                    v-for="tag in filteredTags"
                                    :key="tag.id"
                                    @click="
                                        selectedTag = tag;
                                        addTag();
                                    "
                                    class="cursor-pointer hover:bg-gray-200 p-2"
                                >
                                    {{ tag.name }} ({{ tag.spotCount }})
                                </li>
                            </ul>
                            <div v-if="errors.tags" class="text-red-500">{{ errors.tags }}</div>
                        </div>
                        <div class="text-center mt-3">
                            <StoreTag />
                        </div>
                    </div>
                </div>

                <!-- 説明 -->
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label for="description" class="block text-sm font-medium text-white">説明<span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="description"
                            v-model="form.description"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        />
                        <!-- エラー -->
                        <div v-if="errors.description" class="text-red-500">{{ errors.description }}</div>
                    </div>
                </div>

                <button type="button" @click="addImageForm" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">画像を追加</button>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div v-for="(image, index) in form.images" :key="index" class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <div class="my-5">
                            <label class="mb-2 inline-block text-white dark:text-neutral-200 font-bold" for="image_path">
                                {{ index === 0 ? '結果' : index === 1 ? 'ポジション' : '追加' + (index - 1) }}
                                <span v-if="index === 0 || index === 1" class="text-red-500">*</span>
                            </label>
                            <input
                                class="cursor-pointer relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                                type="file"
                                name="image_path"
                                @change="(e) => onFileChange(e, image)"
                            />
                            <div v-if="errors.images && errors.images[index]" class="text-red-500">{{ errors.images[index].image_path }}</div>
                            <!-- 画像を選択するとプレビューを表示 -->
                            <img :src="image.preview" v-if="image.preview" class="mt-2 w-full h-auto" />
                            <button v-if="index >= 2" type="button" @click="removeImageForm(index)" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">削除</button>
                        </div>

                        <label for="description" class="block text-sm font-medium text-white">説明</label>
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

<style scoped>
ul {
    border: 1px solid #ccc;
    max-height: 100px;
    margin-left: 3px;
    overflow-y: auto;
    background-color: white;
    position: absolute;
    width: 40%;
    z-index: 1000;
    border-radius: 3px;
}
li:hover {
    background-color: #eee;
}

.dropdown-list {
    max-height: 250px;
    overflow-y: auto;
}
</style>
