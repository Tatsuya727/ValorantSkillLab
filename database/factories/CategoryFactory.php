<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        
        $categories = [
            'Aサイト', 'Bサイト', 'ミッド', 'ヘブン', 'ベント', 'ホール', 'ガレージ', 'ロング', 'ショート', 'ボム',
        ];

        $categories = $this->faker->randomElement($categories);

        return [
            'name' => $categories,
            'user_id' => $user->id,
        ];
    }
}
