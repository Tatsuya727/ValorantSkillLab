<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import NavBar from '@/Components/original/NavBar.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    maps: Object,
});

const pageTitle = 'マップ選択';
</script>

<template>
    <Head :title="pageTitle" />

    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-zinc-900">
            <div class="flex flex-wrap justify-center p-10 gap-4 bg-neutral-700 mt-5 mx-5 pb-10 rounded">
                <ul v-for="map in maps" :key="map.id" class="w-1/4">
                    <li>
                        <Link :href="route('characters.index', { mapName: map.name, selectedMap: map.id })">
                            <img :src="map.image_path" :alt="map.name" class="w-full h-auto" loading="lazy" />
                        </Link>
                    </li>
                </ul>
            </div>
        </v-main>
    </v-app>
</template>
