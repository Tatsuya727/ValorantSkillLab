<script setup>
import { Inertia } from '@inertiajs/inertia';
import { ref, reactive } from 'vue';

// const props = defineProps({
//     errors: {
//         type: Object,
//         required: true,
//     },
// });

const dialog = ref(false);

const form = reactive({
    name: null,
});

const storeCategory = () => {
    Inertia.post('/categories', form);
};
</script>

<template>
    <div class="mx-20 mt-4 text-right">
        <v-btn @click="dialog = true">カテゴリーを追加する</v-btn>
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
                        <!-- <div v-if="errors.name" class="text-red-500">{{ errors.name }}</div> -->
                        <v-btn color="success" block class="mt-5">追加</v-btn>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-btn type="button" color="primary" block @click="dialog = false">閉じる</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>
</template>
