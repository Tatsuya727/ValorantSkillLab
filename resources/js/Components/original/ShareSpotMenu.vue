<script setup>
import { ref } from 'vue';

const props = defineProps({
    spot: Object,
    userCategories: Array,
});

const location = ref('end');

const saveDialog = ref(false);
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

            <v-list-item>
                <v-list-item-title @click="deleteCategoryDialog = true" class="cursor-pointer open-delete-dialog"
                    ><v-icon class="mr-2">mdi-content-save-all-outline</v-icon>後で見るに保存</v-list-item-title
                >
            </v-list-item>
        </v-list>
    </v-menu>

    <v-dialog v-model="saveDialog" width="230px">
        <v-card class="text-center">
            <v-card-text>保存先</v-card-text>
            <template v-for="category in props.userCategories" :key="category.id">
                <!-- v-checkboxでカテゴリーの名前を表示 -->
                <v-checkbox v-model="category.checked" :label="category.name"></v-checkbox>
                <!-- <v-checkbox label="Checkbox"></v-checkbox> -->
            </template>

            <v-card-actions>
                <v-btn color="primary" block @click="dialog = false">Close Dialog</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
