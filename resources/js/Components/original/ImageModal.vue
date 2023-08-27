<script setup>
import { defineProps, ref } from 'vue';

const props = defineProps({
    image: {
        type: Object,
        required: true,
    },
    dialog: {
        type: Boolean,
        required: true,
    },
});

const dialog = ref(false);
</script>

<template>
    <!-- <v-dialog v-model="dialog" width="auto">
        <template v-slot:activator="{ props }">
            <v-btn color="primary" v-bind="props"> Open Dialog </v-btn>
        </template>

        <v-card>
            <v-card-text> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </v-card-text>
            <v-card-actions>
                <v-btn color="primary" block @click="dialog = false">Close Dialog</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog> -->
    <div v-if="isOpen" class="fixed z-10 inset-0 overflow-y-auto flex items-center justify-center" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal"></div>
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all w-full relative">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="mt-3 text-center">
                    <div v-if="image.description" class="border p-2 text-gray-500">{{ image.description }}</div>
                    <div v-else class="border p-2 text-gray-500">説明なし</div>
                    <v-img :src="image.image_path" alt="" class="w-full h-1/2"></v-img>
                </div>
            </div>
        </div>
        <v-btn icon class="absolute top-[-310px] right-8" @click="closeModal">
            <v-icon>mdi-close</v-icon>
        </v-btn>
    </div>
</template>
