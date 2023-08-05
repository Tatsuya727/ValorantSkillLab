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
    <v-app-bar color="grey-darken-3">
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title>ValorantSkillLab</v-toolbar-title>

        <Link href="/" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Home</Link>
        <Link :href="route('maps.index')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Map</Link>
        <Link :href="route('characters.index')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Character</Link>
        <Link :href="route('spots.index')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Spot</Link>
        <Link :href="route('spots.create')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">作成</Link>

        <v-spacer></v-spacer>
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" color="grey-darken-3">
        <v-sheet color="grey-darken-4" class="pa-4">
            <v-avatar class="mb-4" color="grey-darken-1" size="64"></v-avatar>

            <div v-if="$page.props.auth.user">{{ $page.props.auth.user.name }}</div>
            <div v-else>
                <v-btn>
                    <Link :href="route('login')">ログイン</Link>
                </v-btn>

                <v-btn class="ml-2">
                    <Link :href="route('register')">新規登録 </Link>
                </v-btn>
            </div>
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
            <v-list-item>
                <Link :href="route('logout')" method="post">ログアウト</Link>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>
