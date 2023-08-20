<script setup>
import NavBar from '@/Components/original/NavBar.vue';
import { defineProps } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
    spots: {
        type: Array,
        required: true,
    },
});
</script>
<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-zinc-900">
            <v-container fluid>
                <div class="bg-neutral-700 pt-5 pb-10 mt-2 rounded"></div>
            </v-container>
        </v-main>
    </v-app>
</template>
