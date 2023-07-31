<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const drawer = ref(null);
const cards = ['Today', 'Yesterday'];
const links = [
    ['mdi-inbox-arrow-down', 'Inbox'],
    ['mdi-send', 'Send'],
    ['mdi-delete', 'Trash'],
    ['mdi-alert-octagon', 'Spam'],
];
</script>

<template>
    <v-navigation-drawer v-model="drawer">
        <v-sheet color="grey-lighten-4" class="pa-4">
            <v-avatar class="mb-4" color="grey-darken-1" size="64"></v-avatar>

            <div>john@google.com</div>
        </v-sheet>

        <v-divider></v-divider>

        <v-list>
            <v-list-item v-for="[icon, text] in links" :key="icon" link>
                <template v-slot:prepend>
                    <v-icon>{{ icon }}</v-icon>
                </template>

                <v-list-item-title>{{ text }}</v-list-item-title>
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
