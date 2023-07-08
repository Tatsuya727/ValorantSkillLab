<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import NavBar from '@/Components/NavBar.vue';

const form = ref({
    name: null,
    description: null,
    user_id: null,
    map_id: null,
    character_id: null,
    image_path: null,
});

const storeSpot = () => {
    Inertia.post('/spots', form);
};
</script>

<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2">
            <v-form @submit.prevent="storeSpot" class="space-y-6">
                <label for="title">title</label>
                <input type="text" name="title" v-model="form.title" />
                <label for="description">description</label>
                <input type="text" name="description" v-model="form.description" />
                <label for="user_id">user_id</label>
                <input type="text" name="user_id" v-model="form.user_id" />
                <label for="map_id">map_id</label>
                <input type="text" name="map_id" v-model="form.map_id" />
                <label for="character_id">character_id</label>
                <input type="text" name="character_id" v-model="form.character_id" />
                <label for="image_path">image_path</label>
                <input type="text" name="image_path" v-model="form.image_path" />
                <button type="submit">作成</button>
            </v-form>
        </v-main>
    </v-app>
</template>
