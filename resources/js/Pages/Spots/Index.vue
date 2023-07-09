<script setup>
import NavBar from '@/Components/NavBar.vue';
import { defineProps, onMounted } from 'vue';

onMounted(() => {
    // console.log(props.spots);
    console.log(spot.images[1]);
});

const props = defineProps({
    spots: {
        type: Array,
        required: true,
    },
});

// idが17のspotを取得
const spot = props.spots.find((spot) => spot.id === 17);
</script>

<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2">
            <v-container>
                <v-row>
                    <template v-for="n in 4" :key="n">
                        <v-col class="mt-2" cols="12">
                            <strong>Category {{ n }}</strong>
                        </v-col>

                        <v-col v-for="j in 6" :key="`${n}${j}`" cols="6" md="2">
                            <img :src="spot.images[1].image_path" alt="" />
                        </v-col>
                    </template>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>
