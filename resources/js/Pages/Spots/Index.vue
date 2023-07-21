<script setup>
import NavBar from '@/Components/NavBar.vue';
import CategoryModal from '@/Components/CategoryModal.vue';
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

// 各カテゴリーの表示状態を管理するオブジェクト
const showCategory = reactive({});

// 初期状態では全てのカテゴリーを表示する
props.categories.forEach((category) => {
    showCategory[category.id] = true;
});

// カテゴリーの表示状態を切り替える関数
const toggleCategory = (categoryId) => {
    showCategory[categoryId] = !showCategory[categoryId];
};

const deleteCategory = (id) => {
    Inertia.delete(route('categories.destroy', { category: id }), {
        onSuccess: () => {
            dialog.value = false;
        },
    });
};

const dialog = ref(false);
</script>

<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2">
            <CategoryModal />
            <v-container>
                <v-row v-if="props.spots">
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
                                            <v-list-item-title @click="dialog = true" class="cursor-pointer"><v-icon>mdi-trash-can-outline</v-icon>削除する</v-list-item-title>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>
                                <!-- 削除ボタンの確認ダイアログ -->
                                <v-dialog v-model="dialog" width="auto">
                                    <v-card>
                                        <v-card-text class="font-bold">本当に削除しますか？</v-card-text>
                                        <v-card-actions>
                                            <v-btn variant="outlined" color="error" block @click="deleteCategory(category.id)">削除する</v-btn>
                                        </v-card-actions>
                                        <v-card-actions>
                                            <v-btn variant="outlined" color="primary" block @click="dialog = false">キャンセル</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </h4>
                        </v-col>
                        <v-expand-transition>
                            <v-col cols="12" v-if="showCategory[category.id]">
                                <div class="flex flex-wrap mx-auto gap-4">
                                    <v-slide-group selected-class="bg-success" show-arrows>
                                        <v-slide-group-item v-for="spot in props.spots" :key="spot.id">
                                            <div v-if="spot.category_id === category.id" class="flex flex-col items-center mb-4 bg-white rounded shadow mr-5">
                                                <Link :href="spot.show_url">
                                                    <img :width="300" cover class="rounded-t" :src="spot.images[0].image_path" alt="" />
                                                </Link>
                                                <div class="p-4">
                                                    <p class="text-sm text-gray-700">{{ spot.description }}</p>
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

<!-- <template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2">
            <v-container>
                <v-row v-if="props.spots">
                    <strong>Category 1</strong>
                    <v-col class="mt-2" cols="12">
                        <div class="flex mx-auto p-10 gap-4">
                            <div v-for="(spot, index) in props.spots" :key="spot.id" class="w-1/6 bg-cyan-400">
                                <div v-for="(image, index) in spot.images" :key="index" class="bg-green-300">
                                    <div v-if="index === 0">
                                        <p>{{ spot.description }}</p>
                                        <Link :href="spot.show_url">
                                            <img class="w-full h-auto" :src="image.image_path" alt="" />
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template> -->
