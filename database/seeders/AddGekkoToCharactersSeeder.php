<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddGekkoToCharactersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('characters')->insert([
            'name' => 'ゲッコー',
            'image_path' => "images/characters/ゲッコー.webp",
        ]);
    }
}
