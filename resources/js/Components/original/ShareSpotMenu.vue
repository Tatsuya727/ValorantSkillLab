<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    spot: Object,
    userCategories: Array,
    flash: Object,
});

const location = ref('end');
const saveDialog = ref(false);

// spotオブジェクトから保存されているカテゴリーのリストを取得
const savedCategories = props.spot.categories || [];

// 保存されているカテゴリーのIDをselectedCategoriesの初期値として設定
const selectedCategories = ref(savedCategories.map((category) => category.id));

const saveSpot = () => {
    Inertia.post(
        route('spotcategory.store'),
        {
            spot: props.spot,
            categories: selectedCategories.value,
        },
        {
            preserveState: true,
            onSuccess: () => {
                if (props.flash.message === '保存しました') {
                    saveDialog.value = false;
                    snackbar.value = true;
                }
            },
        }
    );
};

const alreadySaved = () => {
    if (props.flash.massage === '既に保存されています') {
        return true;
    } else {
        return false;
    }
};

const snackbar = ref(false);

const timeout = ref(5000);
</script>

<template>
    <v-menu :location="location">
        <template v-slot:activator="{ props }">
            <v-icon v-bind="props" class="text-white">mdi-dots-vertical</v-icon>
        </template>

        <v-list>
            <v-list-item>
                <v-list-item-title @click="saveDialog = true" class="cursor-pointer open-update-dialog"><v-icon class="mr-2">mdi-content-save-all</v-icon>保存する</v-list-item-title>
            </v-list-item>

            <!-- <v-list-item>
                <v-list-item-title @click="deleteCategoryDialog = true" class="cursor-pointer open-delete-dialog"
                    ><v-icon class="mr-2">mdi-content-save-all-outline</v-icon>後で見るに保存</v-list-item-title
                >
            </v-list-item> -->
        </v-list>
    </v-menu>

    <v-dialog v-model="saveDialog" max-width="400px">
        <v-card>
            <v-card-title class="headline">保存先</v-card-title>
            <!-- すでにspotがuserCategoriesに登録されている場合、エラーメッセージを表示 -->
            <div v-if="alreadySaved" class="text-red text-center">
                {{ flash.message }}
            </div>
            <v-card-text>
                <v-divider></v-divider>
                <template v-for="category in props.userCategories" :key="category.id">
                    <!-- v-checkboxでカテゴリーの名前を表示 -->
                    <v-checkbox v-model="selectedCategories" :value="category.id" :label="category.name" class="text-black"></v-checkbox>
                </template>
                <v-divider></v-divider>
            </v-card-text>
            <v-card-actions class="justify-end">
                <v-btn color="success" @click="saveSpot">保存する</v-btn>
                <v-btn color="primary" text @click="saveDialog = false">キャンセル</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <!-- フラッシュメッセージ -->
    <div class="text-center">
        <v-snackbar v-model="snackbar" :timeout="timeout" color="white" elevation="24">
            <div v-if="flash">
                {{ flash.message }}
            </div>
        </v-snackbar>
    </div>
</template>
