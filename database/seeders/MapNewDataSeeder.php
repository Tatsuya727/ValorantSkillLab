<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MapNewDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newMaps = [
            'アイスボックス', 'サンセット'
        ];

        foreach ($newMaps as $newMap) {
            DB::table('maps')->insert([
                'name' => $newMap,
                'image_path' => "images/maps/{$newMap}.jpg",
            ]);
        }
    }
}
