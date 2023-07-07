<script setup>
import { ref, onMounted } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    maps: Array,
});
</script>

<template>
    <div class="flex flex-wrap justify-center mx-auto p-10 gap-4">
        <ul v-for="map in maps" :key="map.id" class="w-1/4">
            <li>
                <img
                    :src="map.image_path"
                    :alt="map.name"
                    class="w-full h-auto"
                />
            </li>
        </ul>
    </div>
</template>
