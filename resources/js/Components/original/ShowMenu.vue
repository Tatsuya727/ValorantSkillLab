<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    spot: {
        type: Object,
        required: true,
    },
});

const deleteSpot = (id) => {
    Inertia.delete(route('spots.destroy', { spot: id }));
};

const dialog = ref(false);
</script>
<template>
    <div v-if="$page.props.auth.user">
        <div v-if="$page.props.auth.user.id === props.spot.user.id" class="text-right mt-5 mr-5">
            <v-menu>
                <template v-slot:activator="{ props }">
                    <v-btn class="mt-5" icon="mdi-dots-horizontal" v-bind="props"></v-btn>
                </template>
                <v-list>
                    <!-- <v-list-item>
                        <Link :href="`/spots/${spot.id}/edit`">
                            <v-list-item-title class="text-black"><v-icon>mdi-pencil</v-icon>編集する(作成中)</v-list-item-title>
                        </Link>
                    </v-list-item> -->
                    <v-list-item>
                        <v-list-item-title @click="dialog = true" class="cursor-pointer"><v-icon>mdi-trash-can-outline</v-icon>削除する</v-list-item-title>
                        <!-- <v-list-item-title @click="deleteSpot(spot.id)" class="cursor-pointer">削除する</v-list-item-title> -->
                    </v-list-item>
                </v-list>
            </v-menu>
            <!-- 削除ボタンの確認ダイアログ -->
            <v-dialog v-model="dialog" width="auto">
                <v-card>
                    <v-card-text class="font-bold">本当に削除しますか？</v-card-text>
                    <v-card-actions>
                        <v-btn variant="outlined" color="error" block @click="deleteSpot(spot.id)">削除する</v-btn>
                    </v-card-actions>
                    <v-card-actions>
                        <v-btn variant="outlined" color="primary" block @click="dialog = false">キャンセル</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
    </div>
    <div v-else class="text-right m-10 pt-10 text-grey">
        作成者: <span class="text-blue">{{ spot.user.name }}</span>
    </div>
</template>
