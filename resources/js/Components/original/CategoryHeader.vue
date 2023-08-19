<script setup>
import { ref, reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    category: Object,
    showCategory: Object,
    filteredSpots: Array,
});

const updateDialog = ref(false);
const deleteCategoryDialog = ref(false);
const form = reactive({
    name: props.category.name,
});
const toggleCategory = (id) => {
    props.showCategory[id] = !props.showCategory[id];
};

const openUpdateDialog = (category) => {
    form.name = category.name;
    updateDialog.value = true;
};

const updateCategory = () => {
    Inertia.put(route('categories.update', props.category.id), form);
    updateDialog.value = false;
};

const deleteCategory = (id) => {
    Inertia.delete(route('categories.destroy', id));
    deleteCategoryDialog.value = false;
};
</script>

<template>
    <v-col class="mt-4 bg-gray-50 rounded" cols="11">
        <h4 class="flex justify-between text-2xl font-bold cursor-pointer" @click="toggleCategory(category.id)">
            <div class="flex items-center text-black">
                <v-icon v-if="showCategory[category.id]" class="text-primary">mdi-chevron-down</v-icon>
                <v-icon v-else class="text-secondary">mdi-chevron-right</v-icon>
                <span class="ml-2 categoryname">
                    {{ category.name }}
                    <span>({{ filteredSpots.length }})</span>
                </span>
            </div>
            <v-menu>
                <template v-slot:activator="{ props }">
                    <v-icon v-bind="props" class="text-gray-600">mdi-dots-vertical</v-icon>
                </template>

                <v-list>
                    <v-list-item>
                        <v-list-item-title @click="openUpdateDialog(category)" class="cursor-pointer open-update-dialog"><v-icon>mdi-pencil</v-icon>名前を変更</v-list-item-title>
                    </v-list-item>

                    <v-list-item>
                        <v-list-item-title @click="deleteCategoryDialog = true" class="cursor-pointer open-delete-dialog"><v-icon>mdi-trash-can-outline</v-icon>削除</v-list-item-title>
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
                                <v-btn type="submit" color="success" block class="mt-5">更新</v-btn>
                            </div>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn class="close-update-dialog" type="button" color="primary" block @click="updateDialog = false">閉じる</v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card>
            </v-dialog>

            <!-- 削除の確認ダイアログ -->
            <v-dialog v-model="deleteCategoryDialog" width="auto">
                <v-card>
                    <v-card-text class="font-bold">本当に削除しますか？</v-card-text>
                    <v-card-actions>
                        <v-btn variant="outlined" color="error" block @click="deleteCategory(category.id)">削除する</v-btn>
                    </v-card-actions>
                    <v-card-actions>
                        <v-btn class="cancel-delete-dialog" variant="outlined" color="primary" block @click="deleteCategoryDialog = false">キャンセル</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </h4>
    </v-col>
</template>
