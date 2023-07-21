<script setup>
import { Inertia } from '@inertiajs/inertia';
import { ref, reactive, watchEffect } from 'vue';
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    category: {
        type: Object,
        required: true,
    },
    modelValue: {
        type: Boolean,
        required: true,
    },
});

const emit = defineEmits(['update:modelValue']);

const form = reactive({
    id: null,
    name: null,
});

watchEffect(() => {
    form.id = props.category.id;
    form.name = props.category.name;
});

const updateCategory = () => {
    Inertia.put('/categories/${form.id}', form);
};

const closeDialog = () => {
    emit('update:modelValue', false);
};
</script>

<template>
    <v-dialog v-model="props.modelValue" width="400">
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
                    <v-btn type="button" color="primary" block @click="closeDialog">閉じる</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-dialog>
</template>
