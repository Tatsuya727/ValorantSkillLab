<script setup>
import NavBar from '@/Components/NavBar.vue';
import { defineProps, onMounted } from 'vue';

const props = defineProps({
    spots: {
        type: Array,
        required: true,
    },
});

console.log(props.spots);
</script>

<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2">
            <v-container>
                <v-row v-if="props.spots">
                    <template v-for="(spot, index) in props.spots" :key="spot.id">
                        <v-col class="mt-2" cols="12">
                            <strong>Category {{ index + 1 }}</strong>
                        </v-col>
                        <div class="flex-auto" v-for="(image, index) in spot.images" :key="index">
                            <p v-if="index === 0">{{ spot.title }}</p>
                            <img class="w-1/5" :src="image.image_path" alt="" v-if="index === 0" />
                        </div>
                    </template>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>
