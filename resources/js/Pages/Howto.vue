<script setup>
import NavBar from '@/Components/original/NavBar.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const pageTitle = 'アプリの使い方';

const selectedImage = ref(null);

const dialog = ref(false);

const openDialog = (image) => {
    dialog.value = true;
    selectedImage.value = image;
};
</script>

<template>
    <Head :title="pageTitle" />

    <v-app id="inspire">
        <NavBar :pageTitle="pageTitle" />
        <v-main class="bg-zinc-900">
            <div class="bg-neutral-700 pt-5 pb-10 mt-5 mx-5 rounded text-gray-200">
                <div class="ml-5">
                    <v-row>
                        <v-col cols="12">
                            <h2>
                                <v-icon>mdi-square</v-icon>
                                <span>作成する</span>
                            </h2>
                        </v-col>
                        <v-col cols="12" class="m-3">
                            <div class="mb-3 text-lg">作成ページで作成すると選んだカテゴリーのページに保存されます。</div>
                            <div class="mb-3 text-lg">画像は最低2つ必要です。3つ、4つと画像を追加することもできます。</div>
                            <div class="mb-3 text-lg">「結果」に空爆がどこに飛ぶかやスキルをどこに設置するかなどの画像を置きます。</div>
                            <div class="mb-3 text-lg">「ポジション」にどこからスキルを打つか、投げるかがわかる画像を置きます。</div>
                        </v-col>
                        <v-col cols="12" class="flex mb-20 border-b">
                            <div class="text-center">
                                <v-img :width="400" class="border-double cursor-pointer" @click="openDialog('images\\Howto\\作成.png')" aspect-ratio="16/9" cover src="images\Howto\作成.png"></v-img>
                                <p>作成ページ</p>
                            </div>
                            <div class="text-center">
                                <v-img
                                    :width="400"
                                    class="border-double cursor-pointer"
                                    @click="openDialog('images\\Howto\\作成完了(カテゴリー).png')"
                                    aspect-ratio="16/9"
                                    cover
                                    src="images\Howto\作成完了(カテゴリー).png"
                                ></v-img>
                                <p>カテゴリーページ</p>
                            </div>
                        </v-col>

                        <v-img :width="400" class="border-double cursor-pointer" @click="openDialog('images\\Howto\\Show.png')" aspect-ratio="16/9" cover src="images\Howto\Show.png"></v-img>
                        <v-img
                            :width="400"
                            class="border-double cursor-pointer"
                            @click="openDialog('images\\Howto\\showメニュー.png')"
                            aspect-ratio="16/9"
                            cover
                            src="images\Howto\showメニュー.png"
                        ></v-img>
                        <v-img :width="400" class="border-double cursor-pointer" @click="openDialog('images\\Howto\\Spot保存.png')" aspect-ratio="16/9" cover src="images\Howto\Spot保存.png"></v-img>
                        <v-img
                            :width="400"
                            class="border-double cursor-pointer"
                            @click="openDialog('images\\Howto\\Spot保存ダイアログ.png')"
                            aspect-ratio="16/9"
                            cover
                            src="images\Howto\Spot保存ダイアログ.png"
                        ></v-img>
                        <v-img
                            :width="400"
                            class="border-double cursor-pointer"
                            @click="openDialog('images\\Howto\\カテゴリー作成ダイアログ.png')"
                            aspect-ratio="16/9"
                            cover
                            src="images\Howto\カテゴリー作成ダイアログ.png"
                        ></v-img>
                        <v-img
                            :width="400"
                            class="border-double cursor-pointer"
                            @click="openDialog('images\\Howto\\カテゴリー内.png')"
                            aspect-ratio="16/9"
                            cover
                            src="images\Howto\カテゴリー内.png"
                        ></v-img>
                        <v-img :width="400" class="border-double cursor-pointer" @click="openDialog('images\\Howto\\タグ選択.png')" aspect-ratio="16/9" cover src="images\Howto\タグ選択.png"></v-img>
                        <v-img
                            :width="400"
                            class="border-double cursor-pointer"
                            @click="openDialog('images\\Howto\\フィルタリング.png')"
                            aspect-ratio="16/9"
                            cover
                            src="images\Howto\フィルタリング.png"
                        ></v-img>
                        <v-img
                            :width="400"
                            class="border-double cursor-pointer"
                            @click="openDialog('images\\Howto\\マップ選択.png')"
                            aspect-ratio="16/9"
                            cover
                            src="images\Howto\マップ選択.png"
                        ></v-img>
                        <v-img :width="400" class="border-double cursor-pointer" @click="openDialog('images\\Howto\\公開設定.png')" aspect-ratio="16/9" cover src="images\Howto\公開設定.png"></v-img>
                        <v-img
                            :width="400"
                            class="border-double cursor-pointer"
                            @click="openDialog('images\\Howto\\公開設定(非公開).png')"
                            aspect-ratio="16/9"
                            cover
                            src="images\Howto\公開設定(非公開).png"
                        ></v-img>
                        <v-img
                            :width="400"
                            class="border-double cursor-pointer"
                            @click="openDialog('images\\Howto\\表示切替(縦).png')"
                            aspect-ratio="16/9"
                            cover
                            src="images\Howto\表示切替(縦).png"
                        ></v-img>
                        <v-img :width="400" class="border-double cursor-pointer" @click="openDialog('images\\Howto\\並び替え.png')" aspect-ratio="16/9" cover src="images\Howto\並び替え.png"></v-img>
                    </v-row>

                    <v-dialog v-model="dialog" width="auto">
                        <v-card>
                            <v-card-text>
                                <div class="my-3 text-center">
                                    <v-img :width="1400" :src="selectedImage" alt="画像" class="w-full h-1/2"></v-img>
                                </div>
                            </v-card-text>
                        </v-card>
                    </v-dialog>
                </div>
            </div>
        </v-main>
    </v-app>
</template>
