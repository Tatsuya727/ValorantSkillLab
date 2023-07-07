<script setup>
import { ref, onMounted } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

const drawer = ref(null);

onMounted(() => {
    console.log(props);
});

const props = defineProps({
    maps: Object,
});
</script>

<template>
    <v-app id="inspire">
        <v-app-bar>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

            <v-toolbar-title>ValorantSkillLab</v-toolbar-title>

            <v-btn text to="/maps">Map</v-btn>
            <v-btn text to="/characters">Character</v-btn>
            <v-btn text to="/">Home</v-btn>
            <v-btn text to="/spots/create">Spot</v-btn>
            <v-btn text to="/users/create">register</v-btn>

            <v-spacer></v-spacer>
        </v-app-bar>

        <v-navigation-drawer v-model="drawer" temporary>
            <div>サイドメニュー</div>
        </v-navigation-drawer>

        <v-main class="bg-grey-lighten-2">
            <div class="flex flex-wrap justify-center mx-auto p-10 gap-4">
                <ul v-for="map in maps" :key="map.id" class="w-1/4">
                    <li>
                        <img
                            :src="map.image_path"
                            :alt="map.name"
                            class="w-full h-auto"
                        />
                    </li>
                </ul>
            </div>
        </v-main>
    </v-app>
</template>
