<script setup>
import NavBar from '@/Components/NavBar.vue';
import StoreCategory from '@/Components/StoreCategory.vue';
import { defineProps, reactive, ref } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    spots: {
        type: Array,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
});

const form = reactive({
    id: null,
    name: null,
});

const showCategory = reactive({});

props.categories.forEach((category) => {
    showCategory[category.id] = true;
});

// カテゴリーの表示状態を切り替える
const toggleCategory = (categoryId) => {
    showCategory[categoryId] = !showCategory[categoryId];
};

// すべてのカテゴリーを開く
const openAllCategory = () => {
    props.categories.forEach((category) => {
        showCategory[category.id] = true;
    });
};

// すべてのカテゴリーを閉じる
const closeAllCategory = () => {
    props.categories.forEach((category) => {
        showCategory[category.id] = false;
    });
};

const openUpdateDialog = (category) => {
    form.id = category.id;
    form.name = category.name;
    updateDialog.value = true;
};

// カテゴリーの更新
const updateCategory = () => {
    Inertia.put(`/categories/${form.id}`, form);
    // ダイアログをとじる
    updateDialog.value = false;
};

// カテゴリーの削除
const deleteCategory = (id) => {
    Inertia.delete(route('categories.destroy', { category: id }), {
        onSuccess: () => {
            deleteDialog.value = false;
        },
    });
};

const updateDialog = ref(false);

const deleteDialog = ref(false);
</script>

<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2">
            <div class="flex text-right">
                <div class="mx-20 mt-4">
                    <v-btn class="mr-3" @click="openAllCategory">すべて開く</v-btn>
                    <v-btn @click="closeAllCategory">すべて閉じる</v-btn>
                </div>
                <div class="ml-auto">
                    <StoreCategory />
                </div>
            </div>
            <v-container>
                <v-row v-if="props.spots" class="mx-15">
                    <template v-for="(category, index) in props.categories" :key="category.id">
                        <v-col class="mt-4 bg-gray-50 rounded" cols="12">
                            <h4 class="flex justify-between text-2xl font-bold cursor-pointer" @click="toggleCategory(category.id)">
                                <div>
                                    <v-icon v-if="showCategory[category.id]">mdi-chevron-down</v-icon>
                                    <v-icon v-else>mdi-chevron-right</v-icon>
                                    {{ category.name }}
                                </div>
                                <v-menu>
                                    <template v-slot:activator="{ props }">
                                        <v-icon v-bind="props">mdi-dots-vertical</v-icon>
                                    </template>

                                    <v-list>
                                        <!-- <v-list-item>
                                            <Link :href="`/categories/${category.id}/edit`">
                                                <v-list-item-title><v-icon>mdi-pencil</v-icon>編集する(作成中)</v-list-item-title>
                                            </Link>
                                        </v-list-item> -->
                                        <v-list-item>
                                            <v-list-item-title @click="openUpdateDialog(category)" class="cursor-pointer"><v-icon>mdi-pencil</v-icon>名前を変更</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item>
                                            <v-list-item-title @click="deleteDialog = true" class="cursor-pointer"><v-icon>mdi-trash-can-outline</v-icon>削除</v-list-item-title>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>

                                <!-- 編集ダイアログ -->
                                <v-dialog v-model="updateDialog" width="400">
                                    <v-card>
                                        <v-form @submit.prevent="updateCategory">
                                            <v-card-text>
                                                <div class="text-center">
                                                    <label for="name" class="m-5 block text-lg font-medium text-gray-700">カテゴリー名</label>
                                                    <input
                                                        type="text"
                                                        name="name"
                                                        v-model="form.name"
                                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                    />
                                                    <!-- <div v-if="errors.name" class="text-red-500">{{ errors.name }}</div> -->
                                                    <v-btn type="submit" color="success" block class="mt-5">更新</v-btn>
                                                </div>
                                            </v-card-text>
                                            <v-card-actions>
                                                <v-btn type="button" color="primary" block @click="updateDialog = false">閉じる</v-btn>
                                            </v-card-actions>
                                        </v-form>
                                    </v-card>
                                </v-dialog>

                                <!-- 削除の確認ダイアログ -->
                                <v-dialog v-model="deleteDialog" width="auto">
                                    <v-card>
                                        <v-card-text class="font-bold">本当に削除しますか？</v-card-text>
                                        <v-card-actions>
                                            <v-btn variant="outlined" color="error" block @click="deleteCategory(category.id)">削除する</v-btn>
                                        </v-card-actions>
                                        <v-card-actions>
                                            <v-btn variant="outlined" color="primary" block @click="deleteDialog = false">キャンセル</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </h4>
                        </v-col>
                        <!-- spot -->
                        <v-expand-transition>
                            <v-col cols="12" v-if="showCategory[category.id]">
                                <div class="flex flex-wrap mx-auto gap-4">
                                    <v-slide-group selected-class="bg-success" show-arrows>
                                        <v-slide-group-item v-for="spot in props.spots" :key="spot.id">
                                            <div v-if="spot.category_id === category.id" class="flex flex-col items-center mb-4 bg-white rounded shadow mr-5">
                                                <Link :href="spot.show_url">
                                                    <img :width="300" cover class="rounded-t" :src="spot.images[0].image_path" alt="" />
                                                </Link>
                                                <div class="p-2">
                                                    <div class="flex">
                                                        <p class="text-sm text-gray-700 mx-3">
                                                            map: <span class="font-bold">{{ spot.map.name }}</span>
                                                        </p>
                                                        <p class="text-sm text-gray-700">
                                                            character: <span class="font-bold">{{ spot.character.name }}</span>
                                                        </p>
                                                    </div>
                                                    <p class="text-sm text-gray-700 text-center">
                                                        title: <span class="font-bold">{{ spot.title }}</span>
                                                    </p>
                                                    <!-- タグの名前をすべて表示 -->
                                                    <div class="flex justify-center">
                                                        <div
                                                            v-for="(tag, index) in spot.tags"
                                                            :key="index"
                                                            class="border-2 border-cyan-500 rounded-lg px-3 py-1 text-sm font-semibold text-gray-700 mr-2"
                                                        >
                                                            {{ tag.name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </v-slide-group-item>
                                    </v-slide-group>
                                </div>
                            </v-col>
                        </v-expand-transition>
                    </template>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>
