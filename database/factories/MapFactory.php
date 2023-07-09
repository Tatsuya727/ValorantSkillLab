<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Map>
 */
class MapFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $maps = [
            'アセント', 'スプリット', 'パール', 'バインド', 'フラクチャー', 'ブリーズ', 'ヘイヴン', 'ロータス'
        ];

        $map = $this->faker->randomElement($maps);

        return [
            'name' => $map,
            'image_path' => "images/maps/{$map}.jpg",
        ];
    }
}
