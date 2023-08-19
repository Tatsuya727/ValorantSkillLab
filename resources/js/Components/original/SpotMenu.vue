<script setup>
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    spot: {
        type: Object,
        required: true,
    },
});

const deleteSpotId = ref(null);

const deleteSpotDialog = ref(false);

// Spotの削除
const setDeleteSpotId = (id) => {
    deleteSpotId.value = id;
    deleteSpotDialog.value = true;
};

// Spotの削除
const deleteSpot = () => {
    Inertia.delete(route('spots.destroy', { spot: deleteSpotId.value }), {
        onSuccess: () => {
            deleteSpotDialog.value = false;
        },
    });
};
</script>
<template>
    <v-menu>
        <template v-slot:activator="{ props }">
            <v-icon v-bind="props" class="ml-5 text-white">mdi-dots-vertical</v-icon>
        </template>
        <v-list>
            <v-list-item>
                <v-list-item-title @click="setDeleteSpotId(spot.id)" class="cursor-pointer open-delete-dialog"><v-icon>mdi-trash-can-outline</v-icon>削除する</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-menu>
    <!-- Spot削除ボタンの確認ダイアログ -->
    <v-dialog v-model="deleteSpotDialog" width="auto">
        <v-card>
            <v-card-text class="font-bold">本当に削除しますか？</v-card-text>
            <v-card-actions>
                <v-btn variant="outlined" color="error" block @click="deleteSpot(spot.id)">削除する</v-btn>
            </v-card-actions>
            <v-card-actions>
                <v-btn variant="outlined" color="primary" block @click="deleteSpotDialog = false" class="cancel-delete-dialog">キャンセル</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
