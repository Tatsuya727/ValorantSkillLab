<script setup>
import { ref } from 'vue';
import { Link, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { useMobileDetection } from '@/Hooks/useMobileDetection';

const props = defineProps({
    pageTitle: {
        type: String,
        default: '',
    },
});

const { isMobile } = useMobileDetection();

const drawer = ref(null);
const open = ref(['Category']);

const selectedCategory = ref(null);

// カテゴリーの名前をクリックすると、そのカテゴリーを持つspots.indexに遷移する
const selectCategory = (category) => {
    selectedCategory.value = category;
    Inertia.get(route('spots.index'), { category: selectedCategory.value });
};

const items = [
    { text: 'このアプリについて', icon: 'mdi-information', route: 'about' },
    { text: '作成する', icon: 'mdi-pencil', route: 'spots.create' },
    { text: 'すべての投稿', icon: 'mdi-account-supervisor', route: 'sharespots.index' },
    { text: 'カテゴリー', icon: 'mdi-account', route: 'categories.index' },
    // { text: 'ユーザー', icon: 'mdi-account', route: 'users.index' },
];
</script>

<template>
    <v-app-bar color="grey-darken-3">
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title>
            <Link href="/"> ValorantSkillLab </Link>
        </v-toolbar-title>

        <h2 v-if="!isMobile">{{ pageTitle }}</h2>

        <v-spacer></v-spacer>

        <div class="mr-5 flex">
            <Link :href="route('spots.create')">
                <v-btn v-if="!isMobile" class="mr-5 border bg-green" prepend-icon="mdi-pencil">作成する</v-btn>
            </Link>

            <Link :href="route('login')" v-if="!$page.props.auth.user">
                <v-btn class="border bg-blue">ログイン </v-btn>
            </Link>

            <Link :href="route('register')" v-if="!$page.props.auth.user">
                <v-btn class="ml-2">新規登録</v-btn>
            </Link>
            <v-menu transition="slide-y-transition">
                <template v-slot:activator="{ props }">
                    <v-btn v-if="$page.props.auth.user" class="mr-5" variant="outlined" prepend-icon="mdi-account" v-bind="props">{{ $page.props.auth.user.name }}</v-btn>
                </template>
                <v-list v-if="$page.props.auth.user">
                    <v-list-item v-if="isMobile">
                        <v-list-item-title>
                            <Link :href="route('spots.create')" class="text-black">
                                <v-icon class="mr-4">mdi-pencil</v-icon>
                                作成する
                            </Link>
                        </v-list-item-title>
                    </v-list-item>
                    <v-list-item>
                        <v-list-item-title>
                            <Link :href="route('categories.index')" class="text-black">
                                <v-icon class="mr-4">mdi-account</v-icon>
                                カテゴリー
                            </Link>
                        </v-list-item-title>
                    </v-list-item>
                    <!-- <v-list-item>
                        <v-list-item-title>
                            <Link :href="route('users.index')" class="text-black">
                                <v-icon class="mr-4">mdi-account</v-icon>
                                ユーザーページ
                            </Link>
                        </v-list-item-title>
                    </v-list-item> -->
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

        <v-list v-model:opened="open">
            <v-list-item v-for="(item, i) in items" :key="i" :value="item" :prepend-icon="item.icon">
                <Link :href="route(item.route)">
                    <v-list-item-title v-text="item.text"></v-list-item-title>
                </Link>
            </v-list-item>

            <v-list-group value="Category" v-if="$page.props.auth.user">
                <template v-slot:activator="{ props }">
                    <v-list-item v-bind="props" prepend-icon="mdi-format-list-bulleted" title="マイリスト"></v-list-item>
                </template>

                <v-list-item @click="Inertia.get(route('spots.index'))" prepend-icon="mdi-select-all"> 全て </v-list-item>
                <v-list-item @click="Inertia.get(route('spots.index', { liked: true }))" prepend-icon="mdi-heart"> いいね </v-list-item>
                <v-list-item @click="Inertia.get(route('spots.index', { user_id: $page.props.auth.user.id }))" prepend-icon="mdi-account"> 自分の投稿 </v-list-item>
                <v-list-item
                    v-for="category in $page.props.NavCategories"
                    :key="category.id"
                    @click="selectCategory(category)"
                    :title="category.name"
                    :value="category.name"
                    prepend-icon="mdi-format-list-bulleted"
                ></v-list-item>
            </v-list-group>

            <!-- <v-list-item prepend-icon="mdi-pencil">
                <Link :href="route('spots.create')" :class="{ 'text-blue-500': $page.component === 'Spots/Create' }"> 作成する </Link>
            </v-list-item>

            <v-list-item prepend-icon="mdi-account-supervisor">
                <Link :href="route('sharespots.index')" :class="{ 'text-blue-500': $page.component === 'ShareSpots/Index' }">
                    <v-list-item-title>みんなの投稿</v-list-item-title>
                </Link>
            </v-list-item> -->
        </v-list>
    </v-navigation-drawer>
</template>
