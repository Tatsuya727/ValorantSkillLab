<?php

namespace Tests\Feature;

use App\Models\Spot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShareSpotControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_correct_response()
    {
        $response = $this->get(route('sharespots.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('ShareSpots/Index'));
    }

    public function test_index_filters_spots_by_query_parameters()
    {
        // 既存のSpotをすべて削除
        Spot::query()->delete();

        // 新しいSpotを作成
        $spot = Spot::factory()->create(['title' => 'Test Spot']);

        $response = $this->get(route('sharespots.index', ['search' => 'Test Spot']));

        // レスポンスからspotsのデータを取得
        $spots = $response->viewData('page')['props']['spots']['data'];

        // スポットの数を確認
        $this->assertCount(1, $spots);

        // スポットのタイトルを確認
        $this->assertEquals('Test Spot', $spots[0]['title']);
    }


    public function test_index_returns_user_categories_when_authenticated()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('sharespots.index'));

        $response->assertInertia(fn ($page) => $page->has('userCategories'));
    }

    public function test_index_returns_correct_spot_counts()
    {
        // 既存のSpotをすべて削除
        Spot::query()->delete();

        // 新しいSpotを10個作成
        Spot::factory()->count(10)->create();

        $response = $this->get(route('sharespots.index'));

        // レスポンスからspotsのデータを取得
        $spotsData = $response->viewData('page')['props']['spots'];
        $spots = $spotsData['data'];

        // スポットの数を確認
        $this->assertCount(10, $spots);

        // 全体のスポットの数を確認
        $this->assertEquals(10, $spotsData['total']);
    }

}
