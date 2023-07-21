<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category_name = [
            'Aサイト', 'Bサイト', 'Cサイト', 
        ];

        foreach ($category_name as $name) {
            DB::table('categories')->insert([
                'name' => $name,
            ]);
        }
    }
}
