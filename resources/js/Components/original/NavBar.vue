<script setup>
import { ref, inject } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const drawer = ref(null);
const route = inject('route');
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

        <div class="mr-5">
            <v-btn class="mr-5 border border-gray-400 bg-green" prepend-icon="mdi-pencil" @click="Inertia.get(route('spots.create'))">作成する</v-btn>
            <v-menu transition="slide-y-transition">
                <template v-slot:activator="{ props }">
                    <v-btn v-if="$page.props.auth.user" class="mr-5" variant="outlined" prepend-icon="mdi-account" v-bind="props">{{ $page.props.auth.user.name }}</v-btn>
                </template>
                <v-list v-if="$page.props.auth.user">
                    <v-list-item>
                        <v-list-item-title><v-icon class="mr-4">mdi-account</v-icon>マイページ</v-list-item-title>
                    </v-list-item>
                    <v-divider></v-divider>
                    <v-list-item>
                        <v-list-item-title>
                            <Link :href="route('logout')" method="post" class="text-black">
                                <v-icon class="mr-4">mdi-logout</v-icon>
                                ログアウト
                            </Link>
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </div>

        <!-- <v-spacer></v-spacer> -->
    </v-app-bar>
    <v-navigation-drawer v-model="drawer" color="grey-darken-3">
        <v-sheet color="grey-darken-4" class="pa-4">
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
            <v-list-item>
                <Link :href="route('categories.index')" :class="{ 'text-blue-500': $page.component === 'Categories/Index' }">
                    <v-list-item-title>
                        <v-icon class="mr-4">mdi-account</v-icon>
                        マイページ
                    </v-list-item-title>
                </Link>
            </v-list-item>
            <v-list-item>
                <Link :href="route('spots.create')" :class="{ 'text-blue-500': $page.component === 'Spots/Create' }">
                    <v-list-item-title>
                        <v-icon class="mr-4">mdi-pencil</v-icon>
                        作成する
                    </v-list-item-title>
                </Link>
            </v-list-item>
            <v-list-item>
                <Link :href="route('sharespots.index')" :class="{ 'text-blue-500': $page.component === 'ShareSpots/Index' }">
                    <v-list-item-title>
                        <v-icon class="mr-4">mdi-account-supervisor</v-icon>
                        みんなの投稿
                    </v-list-item-title>
                </Link>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>
