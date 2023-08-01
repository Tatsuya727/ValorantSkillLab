<script setup>
import { ref, inject } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const drawer = ref(null);
const route = inject('route'); // route関数を注入
const links = [
    ['mdi-map', 'Map', 'maps.index'],
    ['mdi-account', 'Character', 'characters.index'],
    ['mdi-spotlight', 'Spot', 'spots.index'],
    ['mdi-plus-box', 'Create', 'spots.create'],
];
</script>

<template>
    <v-navigation-drawer v-model="drawer">
        <v-sheet color="grey-lighten-4" class="pa-4">
            <v-avatar class="mb-4" color="grey-darken-1" size="64"></v-avatar>

            <div>test user</div>
        </v-sheet>

        <v-divider></v-divider>

        <v-list>
            <v-list-item v-for="[icon, text, routeName] in links" :key="icon" link>
                <Link :href="route(routeName)">
                    <template v-slot:prepend>
                        <v-icon>{{ icon }}</v-icon>
                    </template>

                    <v-list-item-title>{{ text }}</v-list-item-title>
                </Link>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
    <v-app-bar>
        <v-toolbar-title>ValorantSkillLab</v-toolbar-title>

        <Link href="/" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Home</Link>
        <Link :href="route('maps.index')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Map</Link>
        <Link :href="route('characters.index')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Character</Link>
        <Link :href="route('spots.index')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Spot</Link>
        <Link :href="route('spots.create')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">作成</Link>

        <v-spacer></v-spacer>
    </v-app-bar>
</template>
