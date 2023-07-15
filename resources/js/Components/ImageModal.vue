<script setup>
import { ref } from 'vue';

const imageModal = ref({
    isOpen: false,
    image: null,
});

const openImageModal = (image) => {
    imageModal.value.isOpen = true;
    imageModal.value.image = image;
};

const closeImageModal = () => {
    imageModal.value.isOpen = false;
    imageModal.value.image = null;
};
</script>

<template>
    <div v-if="imageModal.isOpen" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeImageModal"></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <img :src="imageModal.image" alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
