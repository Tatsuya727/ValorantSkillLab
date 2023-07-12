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
                    <template v-for="n in 4" :key="n">
                        <v-col class="mt-2" cols="12">
                            <strong>Category {{ n }}</strong>
                        </v-col>

                        <div v-for="spot in props.spots" :key="spot.id">
                            <v-col v-for="(image, index) in spot.images" :key="index">
                                <img class="w-50" :src="image.image_path" alt="" />
                            </v-col>
                        </div>
                    </template>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>
