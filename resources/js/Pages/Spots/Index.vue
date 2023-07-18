<script setup>
import NavBar from '@/Components/NavBar.vue';
import { defineProps } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    spots: {
        type: Array,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2">
            <v-container>
                <v-row v-if="props.spots">
                    <template v-for="(category, index) in props.categories" :key="category.id">
                        <v-col class="mt-4" cols="12">
                            <h4 class="text-2xl font-bold">{{ category.name }}</h4>
                        </v-col>
                        <v-col cols="12">
                            <div class="flex flex-wrap mx-auto p-10 gap-4">
                                <template v-for="spot in props.spots" :key="spot.id">
                                    <div v-if="spot.category_id === category.id" class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-3/12 mb-4 bg-white rounded shadow">
                                        <Link :href="spot.show_url">
                                            <img class="w-full h-auto rounded-t" :src="spot.images[0].image_path" alt="" />
                                        </Link>
                                        <div class="p-4">
                                            <p class="text-sm text-gray-700">{{ spot.description }}</p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </v-col>
                    </template>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<!-- <template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2">
            <v-container>
                <v-row v-if="props.spots">
                    <strong>Category 1</strong>
                    <v-col class="mt-2" cols="12">
                        <div class="flex mx-auto p-10 gap-4">
                            <div v-for="(spot, index) in props.spots" :key="spot.id" class="w-1/6 bg-cyan-400">
                                <div v-for="(image, index) in spot.images" :key="index" class="bg-green-300">
                                    <div v-if="index === 0">
                                        <p>{{ spot.description }}</p>
                                        <Link :href="spot.show_url">
                                            <img class="w-full h-auto" :src="image.image_path" alt="" />
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template> -->
