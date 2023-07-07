<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CharactersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $characters = [
            'KAYO', 'セージ', 'ブリムストーン', 'サイファー', 'ハーバー', 'レイナ', 'アストラ', 'ソーヴァ', 'ブリーチ', 'ジェット',
            'フェイド', 'ヴァイパー', 'オーメン', 'チェンバー', 'ヨル', 'スカイ', 'フェニックス', 'キルジョイ', 'ネオン', 'レイズ'
        ];

        foreach ($characters as $character) {
            DB::table('characters')->insert([
                'name' => $character,
                'image_path' => "images/characters/{$character}.webp",
            ]);
        }
    }
}
