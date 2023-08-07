<script setup>
import { Inertia } from '@inertiajs/inertia';
import { ref, reactive } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';

const dialog = ref(false);
const errorMessage = ref(null);

const form = reactive({
    name: null,
    redirect_to_create: false,
});

const { url, component } = usePage();

// コンポーネントを表示しているページによってredirect_to_createの値を変える
const checkRedirect = () => {
    if (url.value === '/spots/create') {
        form.redirect_to_create = true;
    }
};

const storeCategory = () => {
    if (!form.name) {
        errorMessage.value = 'カテゴリー名を入力してください。';
        return;
    }

    checkRedirect();
    Inertia.post('/categories', form, {
        onSuccess: () => {
            dialog.value = false;
        },
    });
};
</script>

<template>
    <div>
        <v-btn color="success" class="addCategory" @click="dialog = true">カテゴリーを追加する</v-btn>
    </div>

    <v-dialog v-model="dialog" width="400">
        <v-card>
            <v-form @submit.prevent="storeCategory">
                <v-card-text>
                    <div class="text-center">
                        <label for="name" class="m-5 block text-lg font-medium text-gray-700">カテゴリー名</label>
                        <input
                            type="text"
                            name="name"
                            v-model="form.name"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        />
                        <div class="text-red-500">{{ errorMessage }}</div>
                        <v-btn type="submit" color="success" block class="mt-5">追加</v-btn>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-btn type="button" color="primary" block @click="dialog = false">閉じる</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>
</template>
