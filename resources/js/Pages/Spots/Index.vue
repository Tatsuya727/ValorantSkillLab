<script setup>
import NavBar from '@/Components/NavBar.vue';
import { defineProps, onMounted } from 'vue';

const props = defineProps({
    spots: {
        type: Array,
        required: true,
    },
});

console.log(props.spots);

// idが43のスポットの画像パスを取得
const spot = props.spots.find((spot) => spot.id === 46);
</script>

<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2">
            <v-container>
                <v-row>
                    <strong>Category 1</strong>
                    <img :src="spot.images[1].image_path" alt="" />
                    <!-- <div v-for="spot in props.spots" :key="spot.id">
                        <img v-if="spot.images[1]" src="spot.images[1].image_path" alt="" />
                    </div> -->
                    <!-- <template v-for="n in 4" :key="n">
                        <v-col class="mt-2" cols="12">
                            <strong>Category {{ n }}</strong>
                        </v-col>

                        <v-col v-for="j in 6" :key="`${n}${j}`" cols="6" md="2">
                            <img :src="'/' + spot.images[1].image_path" alt="" />

                            <img src="images/KP5EJozwLB.png" alt="" />
                        </v-col>
                    </template> -->
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>
