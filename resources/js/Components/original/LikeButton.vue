<script setup>
import { ref } from 'vue';
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
        <div @click="toggleLike(spot)">
            <template v-if="spot.is_liked_by_user">
                <v-icon class="cursor-pointer">mdi-heart</v-icon>
                {{ spot.liked_by_count }}
            </template>
            <template v-else>
                <v-icon class="cursor-pointer">mdi-heart-outline</v-icon>
                {{ spot.liked_by_count }}
            </template>
        </div>
    </div>
</template>
