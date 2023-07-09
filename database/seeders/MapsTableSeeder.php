<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class MapsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $maps = [
            'アセント', 'スプリット', 'パール', 'バインド', 'フラクチャー', 'ブリーズ', 'ヘイヴン', 'ロータス'
        ];

        foreach ($maps as $map) {
            DB::table('maps')->insert([
                'name' => $map,
                'image_path' => "images/maps/{$map}.jpg",
            ]);
        }
    }
}
