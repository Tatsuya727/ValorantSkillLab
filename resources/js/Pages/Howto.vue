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
            <div class="pt-5 pb-10 mt-5 mx-5 rounded text-gray-200">
                <div class="ml-5">
                    <!-- 作成する -->
                    <div class="mb-20">
                        <h2>
                            <v-icon>mdi-square</v-icon>
                            <span>作成する</span>
                        </h2>
                        <div class="ml-10">
                            <div class="m-6">
                                <div class="mb-3 text-lg">・作成ページで作成すると選んだカテゴリーページに保存されます。</div>
                                <div class="mb-3 text-lg">・画像は最低2つ必要です。3つ、4つと画像を追加することもできます。</div>
                                <div class="mb-3 text-lg">・「結果」に空爆がどこに飛ぶかやスキルをどこに設置するかなどの画像を置きます。</div>
                                <div class="mb-3 text-lg">・「ポジション」にどこからスキルを打つか、投げるかがわかる画像を置きます。</div>
                            </div>
                            <div class="flex border-b">
                                <div class="text-center">
                                    <v-img
                                        :width="400"
                                        class="border-double cursor-pointer"
                                        @click="openDialog('images\\Howto\\作成.png')"
                                        aspect-ratio="16/9"
                                        cover
                                        src="images\Howto\作成.png"
                                    ></v-img>
                                    <p>作成ページ</p>
                                </div>
                                <v-icon class="mx-2 align-self-center">mdi-arrow-right-bold-outline</v-icon>
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
                            </div>
                        </div>
                    </div>

                    <!-- カテゴリーに保存した投稿 -->
                    <div class="mb-20">
                        <h2>
                            <v-icon>mdi-square</v-icon>
                            <span>カテゴリーに保存した投稿</span>
                        </h2>
                        <div class="ml-10">
                            <div class="m-6">
                                <div class="mb-3 text-lg">・カテゴリーページでカテゴリーを選択すると、そのカテゴリーに保存した作成ページで作成した投稿、もしくは他人の投稿が表示されます。</div>
                            </div>
                            <div class="flex">
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
                                <v-icon class="mx-2 align-self-center">mdi-arrow-right-bold-outline</v-icon>
                                <div class="text-center">
                                    <v-img
                                        :width="400"
                                        class="border-double cursor-pointer"
                                        @click="openDialog('images\\Howto\\カテゴリー内.png')"
                                        aspect-ratio="16/9"
                                        cover
                                        src="images\Howto\カテゴリー内.png"
                                    ></v-img>
                                    <p>保存された投稿</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 投稿を絞り込む(検索) -->
                    <div class="mb-20">
                        <h2>
                            <v-icon>mdi-square</v-icon>
                            <span>投稿を絞り込む(検索)</span>
                        </h2>
                        <div class="ml-10">
                            <div class="m-6">
                                <div class="mb-3 text-lg">・投稿に表示されているタグやマップ、キャラクターを選択すると選んだ要素をもつ投稿のみを表示します。</div>
                            </div>
                            <div class="flex mb-20 border-b">
                                <div class="text-center">
                                    <v-img
                                        :width="400"
                                        class="border-double cursor-pointer"
                                        @click="openDialog('images\\Howto\\タグ選択.png')"
                                        aspect-ratio="16/9"
                                        cover
                                        src="images\Howto\タグ選択.png"
                                    ></v-img>
                                    <p>タグが選択されている</p>
                                </div>
                                <div class="text-center">
                                    <v-img
                                        :width="400"
                                        class="border-double cursor-pointer"
                                        @click="openDialog('images\\Howto\\マップ選択.png')"
                                        aspect-ratio="16/9"
                                        cover
                                        src="images\Howto\マップ選択.png"
                                    ></v-img>
                                    <p>マップが選択されている</p>
                                </div>
                            </div>

                            <div class="m-6">
                                <div class="mb-3 text-lg">・また、画面上部の「絞り込み」ボタンから表示する投稿を絞り込むことができます。</div>
                                <div class="mb-3 text-lg">・ここではマップ、キャラクター、タグ、カテゴリーをそれぞれ選択できます。(どれか一つだけ選択することも可能)</div>
                            </div>
                            <div class="flex mb-20 border-b">
                                <div class="text-center">
                                    <v-img
                                        :width="400"
                                        class="border-double cursor-pointer"
                                        @click="openDialog('images\\Howto\\フィルタリング.png')"
                                        aspect-ratio="16/9"
                                        cover
                                        src="images\Howto\フィルタリング.png"
                                    ></v-img>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 投稿を保存する -->
                    <div class="mb-20">
                        <h2>
                            <v-icon>mdi-square</v-icon>
                            <span>投稿を保存する</span>
                        </h2>
                        <div class="ml-10">
                            <div class="m-6">
                                <div class="mb-3 text-lg">・このページ、もしくは「すべての投稿」ページで投稿のタイトルの横のアイコンを押すと自分の持つカテゴリーに投稿を保存することができます。</div>
                                <div class="mb-3 text-lg">・ここでは複数のカテゴリーに保存することが可能です。</div>
                                <div class="mb-3 text-lg">・また、新しくカテゴリーを作成することもできます。</div>
                            </div>
                            <div class="flex mb-20 border-b">
                                <div class="text-center">
                                    <v-img
                                        :width="400"
                                        class="border-double cursor-pointer"
                                        @click="openDialog('images\\Howto\\Spot保存.png')"
                                        aspect-ratio="16/9"
                                        cover
                                        src="images\Howto\Spot保存.png"
                                    ></v-img>
                                    <p>投稿のメニューを表示</p>
                                </div>
                                <div class="text-center">
                                    <v-img
                                        :width="400"
                                        class="border-double cursor-pointer"
                                        @click="openDialog('images\\Howto\\Spot保存ダイアログ.png')"
                                        aspect-ratio="16/9"
                                        cover
                                        src="images\Howto\Spot保存ダイアログ.png"
                                    ></v-img>
                                    <p>複数のカテゴリーに保存可能</p>
                                </div>
                                <div class="text-center">
                                    <v-img
                                        :width="400"
                                        class="border-double cursor-pointer"
                                        @click="openDialog('images\\Howto\\カテゴリー作成ダイアログ.png')"
                                        aspect-ratio="16/9"
                                        cover
                                        src="images\Howto\カテゴリー作成ダイアログ.png"
                                    ></v-img>
                                    <p>新しくカテゴリーを作成することも可能</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 投稿の並び替え、表示方法の切り替え -->
                    <div class="mb-20">
                        <h2>
                            <v-icon>mdi-square</v-icon>
                            <span>投稿の並び替え、表示方法の切り替え</span>
                        </h2>
                        <div class="ml-10">
                            <div class="m-6">
                                <div class="mb-3 text-lg">・右の「並び替え」ボタンを押すと投稿を並び替えることができます。</div>
                                <div class="mb-3 text-lg">・「並び替え」ボタンの右のボタンを押すと表示方法を切り替えることができます。</div>
                            </div>
                            <div class="flex mb-20 border-b">
                                <div class="text-center">
                                    <v-img
                                        :width="400"
                                        class="border-double cursor-pointer"
                                        @click="openDialog('images\\Howto\\並び替え.png')"
                                        aspect-ratio="16/9"
                                        cover
                                        src="images\Howto\並び替え.png"
                                    ></v-img>
                                    <p>並び替える</p>
                                </div>
                                <div class="text-center">
                                    <v-img
                                        :width="400"
                                        class="border-double cursor-pointer"
                                        @click="openDialog('images\\Howto\\表示切替(縦).png')"
                                        aspect-ratio="16/9"
                                        cover
                                        src="images\Howto\表示切替(縦).png"
                                    ></v-img>
                                    <p>表示方法を切り替える</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 投稿の詳細ページ -->
                    <div class="mb-20">
                        <h2>
                            <v-icon>mdi-square</v-icon>
                            <span>投稿の詳細ページ</span>
                        </h2>
                        <div class="ml-10">
                            <div class="m-6">
                                <div class="mb-3 text-lg">・投稿を押すとその投稿の詳細ページへ行きます</div>
                            </div>
                            <div class="flex mb-20 border-b">
                                <div class="text-center">
                                    <v-img
                                        :width="400"
                                        class="border-double cursor-pointer"
                                        @click="openDialog('images\\Howto\\カテゴリー内.png')"
                                        aspect-ratio="16/9"
                                        cover
                                        src="images\Howto\カテゴリー内.png"
                                    ></v-img>
                                    <p>保存された投稿</p>
                                </div>
                                <v-icon class="mx-2 align-self-center">mdi-arrow-right-bold-outline</v-icon>
                                <div class="text-center">
                                    <v-img
                                        :width="400"
                                        class="border-double cursor-pointer"
                                        @click="openDialog('images\\Howto\\Show.png')"
                                        aspect-ratio="16/9"
                                        cover
                                        src="images\Howto\Show.png"
                                    ></v-img>
                                    <p>詳細ページ</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 詳細ページのメニュー -->
                    <div class="mb-20">
                        <h2>
                            <v-icon>mdi-square</v-icon>
                            <span>詳細ページのメニュー</span>
                        </h2>
                        <div class="ml-10">
                            <div class="m-6">
                                <div class="mb-3 text-lg">・詳細ページの右上には投稿を他のユーザーに公開するかどうかを切り替えるボタンがあります。</div>
                                <div class="mb-3 text-lg">・また、先ほどのメニューと同じメニューがあります。</div>
                            </div>
                            <div class="flex mb-20 border-b">
                                <div class="text-center">
                                    <v-img
                                        :width="400"
                                        class="border-double cursor-pointer"
                                        @click="openDialog('images\\Howto\\公開設定.png')"
                                        aspect-ratio="16/9"
                                        cover
                                        src="images\Howto\公開設定.png"
                                    ></v-img>
                                    <p>公開設定を切り替える(公開中)</p>
                                </div>
                                <div class="text-center">
                                    <v-img
                                        :width="400"
                                        class="border-double cursor-pointer"
                                        @click="openDialog('images\\Howto\\公開設定(非公開).png')"
                                        aspect-ratio="16/9"
                                        cover
                                        src="images\Howto\公開設定(非公開).png"
                                    ></v-img>
                                    <p>公開設定を切り替える(非公開中)</p>
                                </div>
                                <div class="text-center">
                                    <v-img
                                        :width="400"
                                        class="border-double cursor-pointer"
                                        @click="openDialog('images\\Howto\\showメニュー.png')"
                                        aspect-ratio="16/9"
                                        cover
                                        src="images\Howto\showメニュー.png"
                                    ></v-img>
                                    <p>投稿のメニューを表示</p>
                                </div>
                            </div>
                        </div>
                    </div>

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
