<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Spot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Factories\MapFactory;
use Database\Factories\CharacterFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SpotControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function create_spot()
    {
        $this->withoutExceptionHandling();

        Storage::fake('public');  // フェイクのストレージを作成

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
                ['image_path' => UploadedFile::fake()->image('image1.jpg'), 'description' => $this->faker->sentence],
                ['image_path' => UploadedFile::fake()->image('image2.jpg'), 'description' => $this->faker->sentence],
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

    /** @test */
    public function delete_spot()
    {
        $this->withoutExceptionHandling();

        // テスト用のユーザーを作成
        $user = User::factory()->create();

        // テスト用のSpotを作成
        $spot = Spot::factory()->create(['user_id' => $user->id]);

        // ログイン
        $this->actingAs($user);

        // リクエストの送信
        $response = $this->delete('/spots/' . $spot->id);

        // レスポンスの検証
        $response->assertStatus(302);

        // データベースの検証
        $this->assertDatabaseMissing('spots', [
            'id' => $spot->id,
        ]);
    }
}
