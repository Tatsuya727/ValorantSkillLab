<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\User;

class CategoryTest extends TestCase
{
    /** @test */
    public function create_category()
    {
        $this->withoutExceptionHandling();

        // テスト用のユーザーを作成
        $user = User::factory()->create();

        // ログイン
        $this->actingAs($user);

        // テストデータ
        $data = [
            'name' => 'テストカテゴリー',
        ];

        // リクエストの送信
        $response = $this->post('/categories', $data);

        // レスポンスの検証
        $response->assertStatus(302);

        // データベースの検証
        $this->assertDatabaseHas('categories', [
            'name' => $data['name'],
        ]);
    }

    /** @test */
    public function delete_category()
    {
        $this->withoutExceptionHandling();

        // テスト用のユーザーを作成
        $user = User::factory()->create();

        // ログイン
        $this->actingAs($user);

        // テスト用のカテゴリーを作成
        $category = Category::factory()->create();

        // リクエストの送信
        $response = $this->delete('/categories/' . $category->id);

        // レスポンスの検証
        $response->assertStatus(302);

        // データベースの検証
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }
}
