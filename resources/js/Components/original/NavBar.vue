<script setup>
import { ref, inject } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const drawer = ref(null);
const route = inject('route');
const links = [
    // ['mdi-map', 'Map', 'maps.index', 'Maps/Index'],
    // ['mdi-account', 'Character', 'characters.index', 'Characters/Index'],
    ['mdi-spotlight', 'マイリスト', 'categories.index', 'Categories/Index'],
    ['mdi-pencil', '作成する', 'spots.create', 'Spots/Create'],
    ['mdi-plus-box', 'みんなの投稿', 'sharespots.index', 'ShareSpots/Index'],
];
</script>

<template>
    <v-app-bar color="grey-darken-3">
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title>ValorantSkillLab</v-toolbar-title>

        <!-- <Link href="/" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Home</Link>
        <Link :href="route('maps.index')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Map</Link>
        <Link :href="route('characters.index')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Character</Link>
        <Link :href="route('spots.index')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Spot</Link>
        <Link :href="route('spots.create')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">作成</Link>
        <Link :href="route('sharespots.index')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Post</Link>
        <Link :href="route('categories.index')" class="mr-4 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">Category</Link> -->

        <v-btn class="mr-5 border border-gray-400 bg-green" prepend-icon="mdi-pencil" @click="Inertia.get(route('spots.create'))">作成する</v-btn>
        <v-btn v-if="$page.props.auth.user" class="mr-5" variant="outlined" prepend-icon="mdi-logout">ログアウト</v-btn>

        <!-- <v-spacer></v-spacer> -->
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" color="grey-darken-3">
        <v-sheet color="grey-darken-4" class="pa-4">
            <!-- <v-avatar class="mb-4" color="grey-darken-1" size="64"></v-avatar> -->

            <div v-if="$page.props.auth.user" class="username">{{ $page.props.auth.user.name }}</div>
            <div v-else>
                <Link :href="route('login')">
                    <v-btn>ログイン </v-btn>
                </Link>

                <Link :href="route('register')">
                    <v-btn class="ml-2">新規登録</v-btn>
                </Link>
            </div>
        </v-sheet>

        <v-list>
            <v-list-item v-for="[icon, text, routeName, routeComponent] in links" :key="icon" link>
                <Link :href="route(routeName)" :class="{ 'text-blue-500': $page.component === routeComponent }">
                    <v-list-item-title>
                        <v-icon class="mr-4">{{ icon }}</v-icon>
                        {{ text }}
                    </v-list-item-title>
                </Link>
            </v-list-item>
            <!-- $page.props.auth.userがいない場合は表示しない -->
            <!-- <v-list-item v-if="$page.props.auth.user" link>
                <Link :href="route('logout')" method="post">
                    <v-list-item-title>
                        <v-icon class="mr-4">mdi-logout</v-icon>
                        ログアウト
                    </v-list-item-title>
                </Link>
            </v-list-item> -->
        </v-list>
    </v-navigation-drawer>
</template>
