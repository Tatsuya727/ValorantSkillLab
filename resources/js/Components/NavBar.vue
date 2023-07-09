<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const drawer = ref(null);
</script>

<template>
    <v-app-bar>
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

        <v-toolbar-title>ValorantSkillLab</v-toolbar-title>

        <Link href="/" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Home</Link>
        <Link :href="route('maps.index')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Map</Link>
        <Link :href="route('characters.index')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Character</Link>
        <Link :href="route('spots.index')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Spot</Link>
        <Link :href="route('spots.create')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">作成</Link>

        <v-spacer></v-spacer>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" temporary>
        <div>サイドメニュー</div>
    </v-navigation-drawer>
</template>
