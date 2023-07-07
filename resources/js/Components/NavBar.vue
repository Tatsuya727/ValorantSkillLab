<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const drawer = ref(null);
</script>

<template>
    <v-app-bar>
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

        <v-toolbar-title>ValorantSkillLab</v-toolbar-title>

        <Link :href="route('maps.index')" class="m-4">Map</Link>
        <Link :href="route('characters.index')">Character</Link>
        <Link href="/">Home</Link>

        <v-spacer></v-spacer>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" temporary>
        <div>サイドメニュー</div>
    </v-navigation-drawer>
</template>
