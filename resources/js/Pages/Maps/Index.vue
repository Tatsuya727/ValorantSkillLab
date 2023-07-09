<script setup>
import { ref, onMounted } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import NavBar from '@/Components/NavBar.vue';

const drawer = ref(null);

onMounted(() => {
    console.log(props);
});

const props = defineProps({
    maps: Object,
});
</script>

<template>
    <v-app id="inspire">
        <NavBar />

        <v-main class="bg-grey-lighten-2">
            <div class="flex flex-wrap justify-center mx-auto p-10 gap-4">
                <ul v-for="map in maps" :key="map.id" class="w-1/4">
                    <li>
                        <Link :href="route('characters.index', { mapName: map.name })">
                            <img :src="map.image_path" :alt="map.name" class="w-full h-auto" />
                        </Link>
                    </li>
                </ul>
            </div>
        </v-main>
    </v-app>
</template>
