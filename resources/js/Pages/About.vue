<script setup>
import NavBar from '@/Components/original/NavBar.vue';
import { Head, Link } from '@inertiajs/vue3';

const pageTitle = 'このアプリについて';
</script>

<template>
    <Head :title="pageTitle" />

    <v-app id="inspire">
        <NavBar :pageTitle="pageTitle" />
        <v-main class="bg-zinc-900">
            <div class="bg-neutral-700 pt-5 pb-10 mt-5 mx-5 rounded text-gray-200">
                <div class="ml-5">
                    <h2>
                        <v-icon>mdi-square</v-icon>
                        <span> アプリの説明</span>
                    </h2>
                    <div class="ml-3 mt-5">このアプリはValorantの空爆やセットアップなどを保存、投稿することができるアプリです。</div>
                    <div class="ml-3 mt-5">色んなキャラクターを使っていると定点を良く忘れるけどいちいちyoutubeやtwitterで探すのも面倒だったのでまとめられるサイトを自分用に作りました。</div>
                    <div class="ml-3 mt-3">試合中のラウンドの合間にも見ることができるようにと思って作っています。</div>
                    <div class="ml-3 mt-3">また、投稿された空爆やセットアップは、他のユーザーに公開することもできます。</div>

                    <h2 class="mt-10">
                        <v-icon>mdi-square</v-icon>
                        <span>主な機能</span>
                    </h2>
                    <ul class="ml-3 mt-5">
                        <li>・ 空爆やセットアップなどのポジションを作成、投稿</li>
                        <li>・ マイリストに保存</li>
                        <li>・ フィルタリング機能(マップ、キャラクター、タグ、カテゴリー)</li>
                    </ul>

                    <h2 class="mt-10">
                        <v-icon>mdi-square</v-icon>
                        <span>アプリの使い方</span>
                    </h2>
                    <div class="ml-3 mt-5">アプリの使い方は以下のページをご覧ください。</div>
                    <Link href="/howto" class="m-5"><v-btn>アプリの使い方</v-btn></Link>

                    <h2 class="mt-10">
                        <v-icon>mdi-square</v-icon>
                        <span>注意事項</span>
                    </h2>
                    <div class="ml-3 mt-5">本アプリはChromeで開発しているため、他のブラウザーで意図したとおりに表示されない可能性があります。ご了承ください。</div>

                    <div class="justify-end text-right mt-10">
                        <a href="https://twitter.com/ryuu0727" target="_blank" class="m-5">
                            <v-btn class="text-black bg-blue"> <v-icon>mdi-twitter</v-icon>Twitter </v-btn>
                        </a>
                        <a href="https://github.com/Tatsuya727" target="_blank" class="m-5">
                            <v-btn class="text-white bg-black"><v-icon>mdi-github</v-icon>Github</v-btn>
                        </a>
                    </div>
                </div>
            </div>
        </v-main>
    </v-app>
</template>
