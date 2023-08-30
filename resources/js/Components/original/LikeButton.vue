<script setup>
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    spot: {
        type: Object,
        required: true,
    },
});

// いいね機能
const toggleLike = (spot) => {
    if (spot.is_liked_by_user) {
        Inertia.delete(route('likes.destroy', props.spot.id));
    } else {
        Inertia.post(route('likes.store', props.spot.id));
    }
};
</script>

<template>
    <div class="text-white">
        <div>
            <div v-if="spot.is_liked_by_user" @click="toggleLike(spot)" class="cursor-pointer">
                <v-icon color="pink">mdi-heart</v-icon>
                {{ spot.liked_by_count }}
            </div>
            <div v-else @click="toggleLike(spot)" class="cursor-pointer">
                <v-icon>mdi-heart-outline</v-icon>
                {{ spot.liked_by_count }}
            </div>
        </div>
    </div>
</template>
