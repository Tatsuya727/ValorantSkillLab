<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import NavBar from '@/Components/original/NavBar.vue';

const props = defineProps({
    maps: Object,
});
</script>

<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-zinc-900">
            <div class="flex flex-wrap justify-center p-10 gap-4 bg-neutral-700 mt-5 mx-5 pb-10 rounded">
                <ul v-for="map in maps" :key="map.id" class="w-1/4">
                    <li>
                        <Link :href="route('characters.index', { mapName: map.name, mapId: map.id })">
                            <img :src="map.image_path" :alt="map.name" class="w-full h-auto" />
                        </Link>
                    </li>
                </ul>
            </div>
        </v-main>
    </v-app>
</template>
