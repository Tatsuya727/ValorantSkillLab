<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\User;
use App\Models\Spot;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function in_index_authenticated_user_can_see_categories_and_spots()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);
        $spot = Spot::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('categories.index'));

        $response->assertStatus(200)
            ->assertInertia(fn ($page) => 
                $page->component('Categories/Index')
                    ->has('categories')
                    ->has('spots')
                    ->has('tags')
                    ->has('maps')
                    ->has('characters')
            );
    }
    
    /** @test */
    public function store_creates_a_new_category_and_redirects()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('categories.store'), [
            'name' => 'New Category',
            'redirect_to_create' => false,
        ]);

        $this->assertDatabaseHas('categories', ['name' => 'New Category', 'user_id' => $user->id]);
        $response->assertRedirect(route('categories.index'));
    }
    
    /** @test */
    public function store_redirects_to_spots_create_when_redirect_to_create_is_true()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('categories.store'), [
            'name' => 'New Category',
            'redirect_to_create' => true,
        ]);

        $response->assertRedirect(route('spots.create'));
    }

    
    /** @test */
    public function update_modifies_the_category_and_redirects()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put(route('categories.update', $category), [
            'name' => 'Updated Category',
        ]);

        $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'Updated Category']);
        $response->assertRedirect(route('categories.index'));
    }
    
    /** @test */
    public function destroy_deletes_the_category_and_related_spots_and_redirects()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);
        $spot = Spot::factory()->create(['user_id' => $user->id]);
        $spot->categories()->attach($category);

        $response = $this->actingAs($user)->delete(route('categories.destroy', $category));

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
        $this->assertDatabaseMissing('spots', ['id' => $spot->id]);
        $response->assertRedirect(route('categories.index'))
            ->assertSessionHas('success', 'カテゴリーを削除しました。');
    }

    
    /** @test */
    public function create_category()
    {
        // 作成のテスト
        
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
        // 削除のテスト
        
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
