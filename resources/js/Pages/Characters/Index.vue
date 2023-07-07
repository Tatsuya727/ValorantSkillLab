<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import NavBar from '@/Components/NavBar.vue';

const props = defineProps({
    characters: Object,
});
</script>

<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2">
            <div class="text-center font-bold text-lg">Selected map: {{ $page.props.mapName }}</div>
            <div class="flex flex-wrap justify-center mx-auto p-10 gap-4">
                <ul v-for="character in characters" :key="character.id" class="w-1/6">
                    <li>
                        <img :src="character.image_path" :alt="character.name" class="w-full h-auto shadow-2xl" />
                        <div class="bg-purple-500 text-center font-bold">
                            {{ character.name }}
                        </div>
                    </li>
                </ul>
            </div>
        </v-main>
    </v-app>
</template>
