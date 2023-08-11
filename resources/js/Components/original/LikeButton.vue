<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    spot: {
        type: Object,
        required: true,
    },
});

const isLiked = ref(false);

// いいね機能
const toggleLike = () => {
    if (isLiked.value) {
        Inertia.delete(route('likes.destroy', props.spot.id));
        isLiked.value = false;
    } else {
        Inertia.post(route('likes.store', props.spot.id));
        isLiked.value = true;
    }
};
</script>

<template>
    <div class="text-white">
        <div @click="toggleLike">
            <template v-if="spot.is_liked_by_user">
                <v-icon>mdi-heart</v-icon>
                {{ spot.liked_by_count }}
            </template>
            <template v-else>
                <v-icon>mdi-heart-outline</v-icon>
                {{ spot.liked_by_count }}
            </template>
        </div>
    </div>
</template>
