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
                <!-- 画像を表示 -->
                <img :src="spot.images[0].image_path" alt="" />
            </div>
        </v-main>
    </v-app>
</template>
