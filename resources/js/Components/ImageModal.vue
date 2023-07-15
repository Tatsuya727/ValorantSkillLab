<script setup>
const props = defineProps({
    isOpen: {
        type: Boolean,
        required: true,
    },
    image: {
        type: Object,
        required: true,
    },
    closeModal: {
        type: Function,
        required: true,
    },
});

console.log(props.desc);
</script>

<template>
    <div v-if="isOpen" class="fixed z-10 inset-0 overflow-y-auto flex items-center justify-center" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal"></div>
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-7/10 relative">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <div class="border p-2 text-gray-500">{{ image.description }}</div>
                        <img :src="image.image_path" alt="" class="w-full" />
                    </div>
                </div>
            </div>
        </div>
        <v-btn icon class="absolute top-[-310px] right-8" @click="closeModal">
            <v-icon>mdi-close</v-icon>
        </v-btn>
    </div>
</template>
