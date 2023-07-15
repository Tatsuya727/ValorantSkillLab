<script setup>
import NavBar from '@/Components/NavBar.vue';
import { defineProps, onMounted } from 'vue';

const props = defineProps({
    spot: {
        type: Object,
        required: true,
    },
});
</script>
<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2">
            <div>
                <h1 class="font-bold">{{ spot.title }}</h1>
                <h2>{{ spot.description }}</h2>
                <div class="flex flex-wrap space-4">
                    <div v-for="(image, index) in spot.images" :key="index" class="w-1/4">
                        <img class="object-cover" :src="image.image_path" alt="" />
                    </div>
                </div>
            </div>
        </v-main>
    </v-app>
</template>
