<script setup>
import ImageModal from '@/Components/original/ImageModal.vue';
import ShowMenu from '@/Components/original/ShowMenu.vue';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { useMobileDetection } from '@/Hooks/useMobileDetection';

const props = defineProps({
    spot: {
        type: Object,
        required: true,
    },
    userCategories: {
        type: Array,
        required: false,
    },
    routeName: {
        type: String,
        required: true,
    },
    flash: Object,
});

const { isMobile } = useMobileDetection();

// タグを選択するとそのタグのスポットのみ表示する
const filterSpotsByTag = (tag) => {
    props.selectedTag = tag;
    Inertia.get(route(props.routeName), { selectedTag: props.selectedTag });
};

// props.spot.imagesの数だけdialog(index)を作成
const dialogs = Array(props.spot.images.length)
    .fill(null)
    .map(() => ref(false));
</script>
<template>
    <div class="bg-neutral-700 mt-10 mx-5 pb-20 rounded">
        <ShowMenu :spot="spot" :userCategories="userCategories" :flash="flash" />
        <v-row justify="center">
            <v-col cols="12">
                <div class="text-center">
                    <h1 class="font-bold text-white break-all">{{ spot.title }}</h1>
                    <h1 class="text-white my-2 break-all">{{ spot.description }}</h1>
                    <!-- tagsのnameをすべて表示 -->
                    <div class="flex justify-center my-3">
                        <div v-for="(tag, index) in spot.tags" :key="index">
                            <v-chip color="light-blue-lighten-5" class="py-1 px-3 ml-4 bg-sky-300 text-cyan-800 rounded-full text-sm cursor-pointer" @click="filterSpotsByTag(tag.name)">{{
                                tag.name
                            }}</v-chip>
                        </div>
                    </div>
                </div>
            </v-col>
            <v-divider></v-divider>
            <!-- デスクトップ -->
            <v-col v-if="!isMobile" cols="12">
                <div class="flex space-4 mx-4">
                    <div v-for="(image, index) in spot.images" :key="index" class="justify-center">
                        <v-dialog :v-model="dialogs[index]" width="auto">
                            <template v-slot:activator="{ props }">
                                <v-img
                                    :width="465"
                                    cover
                                    class="object-cover cursor-pointer transform transition-all duration-200 ease-in-out hover:scale-105 hover:shadow-lg"
                                    :src="image.image_path"
                                    alt=""
                                    v-bind="props"
                                    loading="lazy"
                                ></v-img>
                                <div v-if="image.description" class="border border-white p-2 text-white max-w-full break-words" style="max-width: 465px">
                                    {{ image.description }}
                                </div>
                                <div v-else class="border border-white p-2 text-white max-w-full break-words" style="max-width: 465px">説明なし</div>
                            </template>

                            <v-card>
                                <v-card-text>
                                    <div class="mt-3 text-center">
                                        <div v-if="image.description" class="border p-2 text-gray-500">{{ image.description }}</div>
                                        <div v-else class="border p-2 text-gray-500">説明なし</div>
                                        <v-img :width="1000" :src="image.image_path" alt="" class="w-full h-1/2"></v-img>
                                    </div>
                                </v-card-text>
                                <v-card-actions>
                                    <v-btn color="primary" block @click="dialog = false">閉じる</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </div>
                </div>
            </v-col>
            <!-- モバイル端末 -->
            <v-col v-if="isMobile" cols="12">
                <div class="flex flex-wrap space-4 mx-4">
                    <div v-for="(image, index) in spot.images" :key="index" class="justify-center">
                        <v-img
                            :width="350"
                            cover
                            class="object-cover cursor-pointer transform transition-all duration-200 ease-in-out hover:scale-105 hover:shadow-lg"
                            :src="image.image_path"
                            alt=""
                            @click="dialog === true"
                            loading="lazy"
                        ></v-img>
                        <div v-if="image.description" class="border border-white p-2 text-white max-w-full break-words" style="max-width: 350px">
                            {{ image.description }}
                        </div>
                        <div v-else class="border border-white p-2 text-white max-w-full break-words" style="max-width: 350px">説明なし</div>
                    </div>
                </div>
            </v-col>
        </v-row>
    </div>
</template>
