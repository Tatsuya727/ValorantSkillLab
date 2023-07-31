<script setup>
import NavBar from '@/Components/NavBar.vue';
import StoreCategory from '@/Components/StoreCategory.vue';
import { defineProps, reactive, ref } from 'vue';
import { Link, usePage } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    spots: {
        type: Array,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    mapName: {
        type: String,
        required: false,
    },
    mapId: {
        type: Number,
        required: false,
    },
    characterName: {
        type: String,
        required: false,
    },
    characterId: {
        type: Number,
        required: false,
    },
    maps: {
        type: Array,
        required: false,
    },
});

const form = reactive({
    id: null,
    name: null,
});

const showCategory = reactive({});

props.categories.forEach((category) => {
    showCategory[category.id] = true;
});

// カテゴリーの表示状態を切り替える
const toggleCategory = (categoryId) => {
    showCategory[categoryId] = !showCategory[categoryId];
};

// すべてのカテゴリーを開く
const openAllCategory = () => {
    props.categories.forEach((category) => {
        showCategory[category.id] = true;
    });
};

// すべてのカテゴリーを閉じる
const closeAllCategory = () => {
    props.categories.forEach((category) => {
        showCategory[category.id] = false;
    });
};

const openUpdateDialog = (category) => {
    form.id = category.id;
    form.name = category.name;
    updateDialog.value = true;
};

// カテゴリーの更新
const updateCategory = () => {
    Inertia.put(`/categories/${form.id}`, form);
    // ダイアログをとじる
    updateDialog.value = false;
};

// カテゴリーの削除
const deleteCategory = (id) => {
    Inertia.delete(route('categories.destroy', { category: id }), {
        onSuccess: () => {
            deleteCategoryDialog.value = false;
        },
    });
};

const deleteSpotId = ref(null);

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

// ページがロードされるたびにローカルストレージから選択されたタグを読み込む
const selectedTag = ref(localStorage.getItem('selectedTag') || '');

// タグを選択するとそのタグのスポットのみ表示する
const filterSpotsByTag = (tag) => {
    selectedTag.value = tag;
    localStorage.setItem('selectedTag', tag);
    if (props.mapName && props.mapId && props.characterName && props.characterId) {
        Inertia.get(route('spots.index'), {
            tag: tag,
            mapName: props.mapName,
            mapId: props.mapId,
            characterName: props.characterName,
            characterId: props.characterId,
            selectedTag: selectedTag.value,
        });
    } else {
        Inertia.get(route('spots.index'), {
            tag: tag,
        });
    }
};

// ページを離れるときにローカルストレージから選択されたタグを削除する
window.addEventListener('beforeunload', () => {
    localStorage.removeItem('selectedTag');
});

// 画面上部に表示されたタグをクリックすると、タグの絞り込みを解除する
const resetSelectedTag = () => {
    selectedTag.value = '';
    localStorage.removeItem('selectedTag');
    if (props.mapName && props.mapId && props.characterName && props.characterId) {
        Inertia.get(route('spots.index'), {
            mapName: props.mapName,
            mapId: props.mapId,
            characterName: props.characterName,
            characterId: props.characterId,
        });
    } else {
        Inertia.get(route('spots.index'));
    }
};

const updateDialog = ref(false);

const deleteCategoryDialog = ref(false);

const deleteSpotDialog = ref(false);

const selectedMap = ref(null);
const selectedCharacter = ref(null);
</script>

<template>
    <v-app id="inspire">
        <NavBar />
        <v-main class="bg-grey-lighten-2">
            <div class="flex text-right">
                <div class="mx-20 mt-4">
                    <v-btn color="primary" class="mr-3" @click="openAllCategory">すべて開く</v-btn>
                    <v-btn color="secondary" @click="closeAllCategory">すべて閉じる</v-btn>
                </div>
                <div v-if="$page.props.mapName && $page.props.characterName" class="flex items-center space-x-4">
                    <div class="text-lg font-semibold">
                        マップ: <span class="text-blue-600">{{ $page.props.mapName }}</span>
                    </div>
                    <div class="text-lg font-semibold">
                        キャラクター: <span class="text-blue-600">{{ $page.props.characterName }}</span>
                    </div>
                </div>
                <!-- <div>
                    <select v-model="selectedMap" @change="filterSpotsByMap" class="text-lg font-semibold">
                        <option value="" selected>マップを選択</option>
                        <option v-for="map in props.maps" :key="map.id" :value="map.id">{{ map.name }}</option>
                    </select>
                    <select v-model="selectedCharacter" @change="filterSpotsByCharacter" class="text-lg font-semibold">
                        <option value="" selected>キャラクターを選択</option>
                        <option v-for="character in props.characters" :key="character.id" :value="character.id">{{ character.name }}</option>
                    </select>
                </div> -->
                <div v-if="selectedTag" class="mx-20 mt-6 flex">
                    <div class="font-semibold text-lg">選択したタグ:</div>
                    <div @click="resetSelectedTag" class="py-1 px-2 ml-7 bg-sky-300 text-cyan-800 rounded-full text-sm cursor-pointer">
                        <span>
                            {{ selectedTag }}
                        </span>
                        <span class="ml-1">✖</span>
                    </div>
                </div>
                <div class="ml-auto">
                    <StoreCategory />
                </div>
            </div>
            <v-container>
                <v-row v-if="props.spots" class="mx-15">
                    <template v-for="(category, index) in props.categories" :key="category.id">
                        <!-- カテゴリーヘッダー -->
                        <v-col class="mt-4 bg-gray-50 rounded" cols="12">
                            <h4 class="flex justify-between text-2xl font-bold cursor-pointer" @click="toggleCategory(category.id)">
                                <div class="flex items-center">
                                    <v-icon v-if="showCategory[category.id]" class="text-primary">mdi-chevron-down</v-icon>
                                    <v-icon v-else class="text-secondary">mdi-chevron-right</v-icon>
                                    <span class="ml-2">{{ category.name }}</span>
                                </div>
                                <v-menu>
                                    <template v-slot:activator="{ props }">
                                        <v-icon v-bind="props" class="text-gray-600">mdi-dots-vertical</v-icon>
                                    </template>

                                    <v-list>
                                        <v-list-item>
                                            <v-list-item-title @click="openUpdateDialog(category)" class="cursor-pointer"><v-icon>mdi-pencil</v-icon>名前を変更</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item>
                                            <v-list-item-title @click="deleteCategoryDialog = true" class="cursor-pointer"><v-icon>mdi-trash-can-outline</v-icon>削除</v-list-item-title>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>

                                <!-- 編集ダイアログ -->
                                <v-dialog v-model="updateDialog" width="400">
                                    <v-card>
                                        <v-form @submit.prevent="updateCategory">
                                            <v-card-text>
                                                <div class="text-center">
                                                    <label for="name" class="m-5 block text-lg font-medium text-gray-700">カテゴリー名</label>
                                                    <input
                                                        type="text"
                                                        name="name"
                                                        v-model="form.name"
                                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                    />
                                                    <v-btn type="submit" color="success" block class="mt-5">更新</v-btn>
                                                </div>
                                            </v-card-text>
                                            <v-card-actions>
                                                <v-btn type="button" color="primary" block @click="updateDialog = false">閉じる</v-btn>
                                            </v-card-actions>
                                        </v-form>
                                    </v-card>
                                </v-dialog>

                                <!-- 削除の確認ダイアログ -->
                                <v-dialog v-model="deleteCategoryDialog" width="auto">
                                    <v-card>
                                        <v-card-text class="font-bold">本当に削除しますか？</v-card-text>
                                        <v-card-actions>
                                            <v-btn variant="outlined" color="error" block @click="deleteCategory(category.id)">削除する</v-btn>
                                        </v-card-actions>
                                        <v-card-actions>
                                            <v-btn variant="outlined" color="primary" block @click="deleteDialog = false">キャンセル</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </h4>
                        </v-col>
                        <!-- spot -->
                        <v-expand-transition>
                            <v-col cols="12" v-if="showCategory[category.id]">
                                <div class="flex flex-wrap mx-auto gap-4">
                                    <v-slide-group selected-class="bg-success" show-arrows>
                                        <v-slide-group-item v-for="spot in props.spots" :key="spot.id">
                                            <div v-if="spot.category_id === category.id" class="flex flex-col items-center mb-4 bg-white rounded shadow mr-5">
                                                <div v-if="(!$page.props.mapId && !$page.props.characterId) || (spot.map_id == $page.props.mapId && spot.character_id == $page.props.characterId)">
                                                    <!-- spot画像 -->
                                                    <Link :href="spot.show_url">
                                                        <img :width="300" cover class="rounded-t" :src="spot.images[0].image_path" alt="" />
                                                    </Link>
                                                    <div class="p-2">
                                                        <!-- マップとキャラクター -->
                                                        <div class="flex">
                                                            <p class="text-sm text-gray-700 mx-3">
                                                                map: <span class="font-bold">{{ spot.map.name }}</span>
                                                            </p>
                                                            <p class="text-sm text-gray-700">
                                                                character: <span class="font-bold">{{ spot.character.name }}</span>
                                                            </p>
                                                            <v-menu>
                                                                <template v-slot:activator="{ props }">
                                                                    <v-icon v-bind="props" class="ml-5 text-gray-600">mdi-dots-vertical</v-icon>
                                                                </template>
                                                                <v-list>
                                                                    <v-list-item>
                                                                        <v-list-item-title @click="setDeleteSpotId(spot.id)" class="cursor-pointer"
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
                                                                        <v-btn variant="outlined" color="primary" block @click="deleteSpotDialog = false">キャンセル</v-btn>
                                                                    </v-card-actions>
                                                                </v-card>
                                                            </v-dialog>
                                                        </div>
                                                        <p class="text-sm text-gray-700 text-center">
                                                            title: <span class="font-bold">{{ spot.title }}</span>
                                                        </p>
                                                        <!-- タグの名前をすべて表示 -->
                                                        <div class="flex flex-wrap justify-center">
                                                            <div
                                                                v-for="(tag, index) in spot.tags"
                                                                :key="index"
                                                                @click="filterSpotsByTag(tag.name)"
                                                                :class="{
                                                                    'border-2 border-cyan-500 rounded-lg px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 cursor-pointer': !selectedTag.value,
                                                                    'bg-cyan-500 text-white': selectedTag && selectedTag === tag.name,
                                                                }"
                                                            >
                                                                <div>{{ tag.name }}</div>
                                                            </div>
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
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>
