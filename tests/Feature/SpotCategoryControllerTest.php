<?php

namespace Tests\Feature;

use App\Models\Spot;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpotCategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_associates_categories_with_spot_for_authenticated_user()
    {
        $user = User::factory()->create();
        $spot = Spot::factory()->create(['user_id' => $user->id]);
        $category1 = Category::factory()->create(['user_id' => $user->id]);
        $category2 = Category::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post(route('spotcategory.store'), [
            'spot' => ['id' => $spot->id],
            'categories' => [$category1->id, $category2->id]
        ]);

        $this->assertDatabaseHas('category_spot', [
            'spot_id' => $spot->id,
            'category_id' => $category1->id
        ]);

        $this->assertDatabaseHas('category_spot', [
            'spot_id' => $spot->id,
            'category_id' => $category2->id
        ]);

        $response->assertRedirect()
            ->assertSessionHas('message', '保存しました');
    }

    public function test_store_does_not_associate_categories_if_none_selected()
    {
        $user = User::factory()->create();
        $spot = Spot::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post(route('spotcategory.store'), [
            'spot' => ['id' => $spot->id],
            'categories' => []
        ]);

        $this->assertDatabaseMissing('category_spot', [
            'spot_id' => $spot->id
        ]);

        $response->assertRedirect()
            ->assertSessionHas('message', 'カテゴリーを選択してください');
    }

}
