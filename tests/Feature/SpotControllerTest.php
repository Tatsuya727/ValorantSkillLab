<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Factories\MapFactory;
use Database\Factories\CharacterFactory;

class SpotControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_can_create_a_spot()
    {
        $this->withoutExceptionHandling();

        // テスト用のユーザーを作成
        $user = User::factory()->create();

        // テスト用のMapとCharacterを作成
        $map = MapFactory::new()->create();
        $character = CharacterFactory::new()->create();

        // ログイン
        $this->actingAs($user);

        // テストデータ
        $data = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'map_id' => $map->id,
            'character_id' => $character->id,
            'images' => [
                ['image_path' => $this->faker->imageUrl(), 'description' => $this->faker->sentence],
                ['image_path' => $this->faker->imageUrl(), 'description' => $this->faker->sentence],
            ],
        ];

        // リクエストの送信
        $response = $this->post('/spots', $data);

        // レスポンスの検証
        $response->assertStatus(302);

        // データベースの検証
        $this->assertDatabaseHas('spots', [
            'title' => $data['title'],
            'description' => $data['description'],
            'map_id' => $data['map_id'],
            'character_id' => $data['character_id'],
        ]);
    }

}
