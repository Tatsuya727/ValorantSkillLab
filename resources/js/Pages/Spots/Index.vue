<script setup>
import NavBar from '@/Components/NavBar.vue';
import { defineProps } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

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
                            <h1>{{ spot.id }}</h1>
                            <p v-if="index === 0">{{ spot.description }}</p>
                            <Link :href="spot.show_url">
                                <img class="w-1/5" :src="image.image_path" alt="" v-if="index === 0" />
                            </Link>
                        </div>
                    </template>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>
