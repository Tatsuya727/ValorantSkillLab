<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import NavBar from '@/Components/original/NavBar.vue';

const props = defineProps({
    characters: Object,
});
</script>

<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-zinc-900">
            <div class="bg-neutral-700 mt-5 mx-5 pb-10 rounded">
                <div class="text-center font-bold text-lg text-white">選択したマップ: {{ $page.props.mapName }}</div>
                <div class="flex flex-wrap justify-center mx-auto gap-4">
                    <ul v-for="character in characters" :key="character.id" class="w-1/6">
                        <li>
                            <Link :href="route('spots.index', { mapName: $page.props.mapName, mapId: $page.props.mapId, characterName: character.name, characterId: character.id })">
                                <img :src="character.image_path" :alt="character.name" class="w-full h-auto shadow-2xl" loading="lazy" />
                            </Link>
                            <div class="bg-purple-500 text-center font-bold">
                                {{ character.name }}
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </v-main>
    </v-app>
</template>
