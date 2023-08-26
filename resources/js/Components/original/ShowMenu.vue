<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
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
    flash: Object,
});

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

const snackbar = ref(false);

const timeout = ref(5000);

const deleteSpot = (id) => {
    Inertia.delete(route('spots.destroy', { spot: id }));
};

const togglePublic = (spotId) => {
    Inertia.post(
        `/spots/${spotId}/toggle-public`,
        {},
        {
            onSuccess: () => {
                publicDialog.value = false;
            },
            onError: (error) => {
                console.log(error);
            },
        }
    );
};

const dialog = ref(false);
const publicDialog = ref(false);
</script>
<template>
    <div v-if="$page.props.auth.user">
        <div v-if="$page.props.auth.user.id === props.spot.user.id" class="text-right mr-5">
            <v-btn class="mr-5 mt-5" :color="spot.is_public ? 'success' : 'secondary'" @click="publicDialog = true"> 公開設定:{{ spot.is_public ? '公開中' : '非公開中' }} </v-btn>

            <!-- 公開設定のダイアログ -->
            <v-dialog v-model="publicDialog" width="auto">
                <v-card>
                    <v-card-text class="font-bold">公開設定を変更しますか？</v-card-text>
                    <v-card-text class="font-bold">
                        現在は
                        <span :class="{ 'text-red': true, 'font-bold': true }">{{ spot.is_public ? '公開中' : '非公開' }}</span>
                        です。
                    </v-card-text>
                    <v-card-actions>
                        <v-btn :variant="'outlined'" :color="'success'" block @click="togglePublic(spot.id)">
                            {{ spot.is_public ? '非公開にする' : '公開にする' }}
                        </v-btn>
                    </v-card-actions>
                    <v-card-actions>
                        <v-btn variant="outlined" color="primary" block @click="publicDialog = false">キャンセル</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <v-menu>
                <template v-slot:activator="{ props }">
                    <v-btn class="mt-5" icon="mdi-dots-horizontal" v-bind="props"></v-btn>
                </template>
                <v-list>
                    <!-- <v-list-item>
                        <Link :href="`/spots/${spot.id}/edit`">
                            <v-list-item-title class="text-black"><v-icon>mdi-pencil</v-icon>編集する(作成中)</v-list-item-title>
                        </Link>
                    </v-list-item> -->
                    <v-list-item>
                        <v-list-item-title @click="saveDialog = true" class="cursor-pointer open-update-dialog"><v-icon class="mr-2">mdi-content-save-all</v-icon>保存する</v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-title @click="dialog = true" class="cursor-pointer"><v-icon>mdi-trash-can-outline</v-icon>削除する</v-list-item-title>
                        <!-- <v-list-item-title @click="deleteSpot(spot.id)" class="cursor-pointer">削除する</v-list-item-title> -->
                    </v-list-item>
                </v-list>
            </v-menu>
            <!-- 削除ボタンの確認ダイアログ -->
            <v-dialog v-model="dialog" width="auto">
                <v-card>
                    <v-card-text class="font-bold">本当に削除しますか？</v-card-text>
                    <v-card-actions>
                        <v-btn variant="outlined" color="error" block @click="deleteSpot(spot.id)">削除する</v-btn>
                    </v-card-actions>
                    <v-card-actions>
                        <v-btn variant="outlined" color="primary" block @click="dialog = false">キャンセル</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
    </div>
    <div v-else class="text-right m-10 pt-10 text-grey">
        作成者: <span class="text-blue">{{ spot.user.name }}</span>
    </div>

    <v-dialog v-model="saveDialog" max-width="400px">
        <v-card>
            <v-card-title class="headline">保存先</v-card-title>
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
