<script setup>
import NavBar from '@/Components/original/NavBar.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
});

const pageTitle = 'マイページ';
</script>
<template>
    <Head :title="pageTitle" />

    <v-app id="inspire">
        <NavBar :pageTitle="pageTitle" />
        <v-main class="bg-zinc-900">
            <div class="bg-neutral-700 pt-5 pb-10 m-5 rounded">
                <div>
                    <h1>{{ user.name }}</h1>
                </div>
            </div>
        </v-main>
    </v-app>
</template>
