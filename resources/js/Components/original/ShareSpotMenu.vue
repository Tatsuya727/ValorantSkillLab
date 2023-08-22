<script setup>
import { ref } from 'vue';

const props = defineProps({
    spot: Object,
    userCategories: Array,
});

const location = ref('end');
const saveDialog = ref(false);
const selectedCategories = ref([]);

const saveSpot = () => {
    console.log(selectedCategories);
    Inertia.post(route('spots.store'), {
        spot: props.spot,
        categories: selectedCategories.value,
    });
};
</script>

<template>
    <v-menu :location="location">
        <template v-slot:activator="{ props }">
            <v-icon v-bind="props" class="text-white">mdi-dots-vertical</v-icon>
        </template>

        <v-list>
            <v-list-item>
                <v-list-item-title @click="saveDialog = true" class="cursor-pointer open-update-dialog"><v-icon class="mr-2">mdi-content-save-all</v-icon>保存する</v-list-item-title>
            </v-list-item>

            <!-- <v-list-item>
                <v-list-item-title @click="deleteCategoryDialog = true" class="cursor-pointer open-delete-dialog"
                    ><v-icon class="mr-2">mdi-content-save-all-outline</v-icon>後で見るに保存</v-list-item-title
                >
            </v-list-item> -->
        </v-list>
    </v-menu>

    <v-dialog v-model="saveDialog" max-width="400px">
        <v-card>
            <v-card-title class="headline">保存先</v-card-title>
            <v-card-text>
                <v-divider></v-divider>
                <v-list dense>
                    <template v-for="category in props.userCategories" :key="category.id">
                        <!-- v-checkboxでカテゴリーの名前を表示 -->
                        <v-list-item>
                            <v-list-item-content>
                                <v-checkbox v-model="category.checked" :label="category.name" class="text-black"></v-checkbox>
                            </v-list-item-content>
                        </v-list-item>
                    </template>
                </v-list>
                <v-divider></v-divider>
            </v-card-text>
            <v-card-actions class="justify-end">
                <v-btn color="success" @click="saveToCategory">保存する</v-btn>
                <v-btn color="primary" text @click="saveDialog = false">キャンセル</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
