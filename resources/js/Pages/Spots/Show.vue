<script setup>
import NavBar from '@/Components/original/NavBar.vue';
import ShowSpot from '@/Components/original/ShowSpot.vue';
import FlashMessage from '@/Components/original/FlashMessage.vue';
import { Head } from '@inertiajs/inertia-vue3';

// import draggable from 'vuedraggable';

const props = defineProps({
    spot: {
        type: Object,
        required: true,
    },
    userCategories: {
        type: Array,
        required: false,
    },
    flash: Object,
});

const pageTitle = props.spot.title;
</script>
<template>
    <Head :title="pageTitle" />

    <v-app id="inspire">
        <NavBar :pageTitle="pageTitle" />
        <v-main class="bg-zinc-900">
            <ShowSpot :spot="spot" :userCategories="userCategories" :routeName="'spots.index'" />
            <FlashMessage :flash="flash" />
        </v-main>
    </v-app>
</template>
