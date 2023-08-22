<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Spot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Factories\MapFactory;
use Database\Factories\CharacterFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\TagFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SpotControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function index_spot()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/spots');

        $response->assertStatus(200);
    }

    /** @test */
    public function show_spot()
    {

        $user = User::factory()->create();

        $spot = Spot::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->get('/spots/' . $spot->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function create_spot()
    {
        // 作成画面の表示のテスト

        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/spots/create');

        $response->assertStatus(200);
    }

    /** @test */
    public function store_spot()
    {
        // 作成のテスト

        Storage::fake('public');  // フェイクのストレージを作成

        // テスト用のユーザーを作成
        $user = User::factory()->create();

        // テスト用のMapとCharacterとCategoryとTagを作成
        $map = MapFactory::new()->create();
        $character = CharacterFactory::new()->create();
        $category = CategoryFactory::new()->create();
        $tag = TagFactory::new()->create();

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
            'categories' => [
                $category->id,
            ],
            'tags' => [
                $tag->id,
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
        // 削除のテスト
        
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
