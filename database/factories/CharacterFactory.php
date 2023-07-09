<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Character>
 */
class CharacterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $characters = [
            'KAYO', 'セージ', 'ブリムストーン', 'サイファー', 'ハーバー', 'レイナ', 'アストラ', 'ソーヴァ', 'ブリーチ', 'ジェット',
            'フェイド', 'ヴァイパー', 'オーメン', 'チェンバー', 'ヨル', 'スカイ', 'フェニックス', 'キルジョイ', 'ネオン', 'レイズ'
        ];

        $character = $this->faker->randomElement($characters);

        return [
            'name' => $character,
            'image_path' => "images/characters/{$character}.webp",
        ];
    }
}
