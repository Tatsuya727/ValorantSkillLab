<script setup>
import { ref, reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    category: Object,
});

const updateDialog = ref(false);
const deleteCategoryDialog = ref(false);
const form = reactive({
    name: props.category.name,
});

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
    <v-menu>
        <template v-slot:activator="{ props }">
            <v-icon v-bind="props" class="text-white hover:text-gray-400 text-xl">mdi-dots-vertical</v-icon>
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
                        <label for="name" class="mb-5 block text-lg font-medium text-gray-700">カテゴリー名</label>
                        <input
                            type="text"
                            name="name"
                            v-model="form.name"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        />
                        <v-btn type="submit" color="success" block class="mt-5">更新</v-btn>
                    </div>
                </v-card-text>
                <v-card-actions class="justify-center">
                    <v-btn class="close-update-dialog" type="button" color="primary" block @click="updateDialog = false">閉じる</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>

    <!-- 削除の確認ダイアログ -->
    <v-dialog v-model="deleteCategoryDialog" width="auto">
        <v-card class="text-center bg-red-100">
            <v-card-title class="font-bold text-red-600 mb-3">
                <v-icon class="mr-2">mdi-alert-circle</v-icon>
                カテゴリー削除の確認
            </v-card-title>
            <v-card-text class="font-medium mb-3">
                「<span class="font-bold text-red-600">{{ category.name }}</span
                >」を削除すると、この中にあるすべての内容も消えてしまいます。
            </v-card-text>
            <v-card-text class="font-medium mb-5">本当に削除しますか？</v-card-text>
            <v-card-actions class="justify-center">
                <v-btn variant="contained" color="error" class="mr-3 px-5 py-2" @click="deleteCategory(category.id)">削除する</v-btn>
                <v-btn variant="contained" color="primary" class="px-5 py-2" @click="deleteCategoryDialog = false">キャンセル</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
