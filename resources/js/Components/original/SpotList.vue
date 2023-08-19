<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { defineEmits, ref, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import SpotTags from '@/Components/original/SpotTags.vue';
import CategoryHeader from '@/Components/original/CategoryHeader.vue';

const props = defineProps({
    spots: {
        type: Array,
        required: true,
    },
    category: {
        type: Object,
        required: true,
    },
    showCategory: {
        type: Object,
        required: true,
    },
    selectedTag: {
        type: String,
        required: false,
    },
    selectedMap: {
        type: Number,
        required: false,
    },
    selectedCharacter: {
        type: Number,
        required: false,
    },
});

// category.id と一致する spot のみをフィルタリングする computed property
const filteredSpots = computed(() => {
    return props.spots.filter((spot) => spot.category_id === props.category.id);
});

// 親コンポーネントにfilteredSpotsを返す
const emits = defineEmits(['filteredSpots']);

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


// カテゴリーの表示・非表示を切り替える
if (props.categories) {
    props.categories.forEach((category) => {
        showCategory[category.id] = true;
    });
}

const deleteSpotId = ref(null);

const deleteSpotDialog = ref(false);
</script>

<template>
    <!-- カテゴリーヘッダー -->
    <CategoryHeader :category="category" :showCategory="showCategory" :filteredSpots="filteredSpots" />
    <v-expand-transition>
        <v-col cols="11" v-if="showCategory[category.id]">
            <div class="flex flex-wrap mx-auto gap-4">
                <v-slide-group selected-class="bg-success" show-arrows>

                    <div v-if="filteredSpots.length === 0" class="text-white text-center text-lg font-bold">無し</div>
                    <v-slide-group-item v-for="spot in filteredSpots" :key="spot.id">
                        <div class="flex flex-col items-center mb-4 rounded shadow mr-5">
                            <div>

                                <!-- spot画像 -->
                                <Link :href="spot.show_url">
                                    <img :width="300" cover class="rounded-t" :src="spot.images[0].image_path" alt="サムネイル画像" loading="lazy" />
                                </Link>
                                <div class="p-2 bg-neutral-800 mt-[-7px]">
                                    <!-- マップとキャラクター -->
                                    <div class="flex justify-between">
                                        <div>
                                            <p class="text-sm text-gray-700 text-white">
                                                map: <span class="font-bold">{{ spot.map.name }}</span>
                                            </p>
                                            <p class="text-sm text-gray-700 text-white">
                                                character: <span class="font-bold">{{ spot.character.name }}</span>
                                            </p>
                                        </div>
                                        <v-menu>
                                            <template v-slot:activator="{ props }">
                                                <v-icon v-bind="props" class="ml-5 text-white">mdi-dots-vertical</v-icon>
                                            </template>
                                            <v-list>
                                                <v-list-item>
                                                    <v-list-item-title @click="setDeleteSpotId(spot.id)" class="cursor-pointer open-delete-dialog"
                                                        ><v-icon>mdi-trash-can-outline</v-icon>削除する</v-list-item-title
                                                    >
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
                                    </div>
                                    <p class="text-sm text-gray-700 text-center spot-title text-white">
                                        title: <span class="font-bold">{{ spot.title }}</span>
                                    </p>
                                    <!-- タグの名前をすべて表示 -->
                                    <div class="flex flex-wrap justify-center">
                                        <SpotTags :tags="spot.tags" :selectedMap="props.selectedMap" :selectedCharacter="props.selectedCharacter" :routeName="'spots.index'" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </v-slide-group-item>
                </v-slide-group>
            </div>
        </v-col>
    </v-expand-transition>
</template>
