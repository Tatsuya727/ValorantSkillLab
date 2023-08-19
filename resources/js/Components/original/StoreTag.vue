<script setup>
import { Inertia } from '@inertiajs/inertia';
import { ref, reactive } from 'vue';

const dialog = ref(false);
const errorMessage = ref(null);

const form = reactive({
    name: null,
});

const storeTag = () => {
    if (!form.name) {
        errorMessage.value = 'タグ名を入力してください。';
        return;
    }

    Inertia.post(route('tags.store'), form, {
        onSuccess: () => {
            dialog.value = false;
        },
        onError: (errors) => {
            errorMessage.value = errors.name;
            console.log(errors);
        },
    });
};
</script>

<template>
    <div>
        <v-btn color="success" class="addTag" @click="dialog = true">タグを追加する</v-btn>
    </div>

    <v-dialog v-model="dialog" width="400">
        <v-card>
            <v-form @submit.prevent="storeTag">
                <v-card-text>
                    <div class="text-center">
                        <label for="name" class="m-5 block text-lg font-medium text-gray-700">タグ名</label>
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
