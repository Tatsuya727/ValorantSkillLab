<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tags = [
            'Aサイト', 'Bサイト', 'ミッド', 'ヘブン', 'ベント', 'ホール', 'ガレージ', 'ロング', 'ショート', 'ボム',
        ];

        $tags = $this->faker->randomElement($tags);

        return [
            'name' => $tags,
        ];
    }
}
