<?php

namespace Tests\Feature;

use App\Models\Spot;
use App\Models\User;
use App\Models\Map;
use App\Models\Character;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Factories\MapFactory;
use Database\Factories\CharacterFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\TagFactory;




class SpotControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index_displays_spots_for_authenticated_user()
    {
        $user = User::factory()->create();
        $spot = Spot::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('spots.index'));

        $response->assertStatus(200)
            ->assertInertia(fn ($page) => 
                $page->component('Spots/Index')
                    ->has('spots')
                    ->has('categories')
                    ->has('characters')
                    ->has('maps')
                    ->has('tags')
                    ->has('userCategories')
            );
    }

    public function test_create_displays_create_form_for_authenticated_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('spots.create'));

        $response->assertStatus(200)
            ->assertInertia(fn ($page) => 
                $page->component('Spots/Create')
                    ->has('maps')
                    ->has('characters')
                    ->has('categories')
                    ->has('tags')
            );
    }

    public function test_store_creates_a_new_spot_and_redirects()
    {
        Storage::fake('public');  // フェイクのストレージを作成

        $user = User::factory()->create();
        $map = MapFactory::new()->create();
        $character = CharacterFactory::new()->create();
        $category = CategoryFactory::new()->create();
        $tag = TagFactory::new()->create();

        $this->actingAs($user);

        // テストデータ
        $data = [
            'title' => 'New Spot',
            'description' => 'Spot Description',
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

        $response = $this->post(route('spots.store'), $data);

        $this->assertDatabaseHas('spots', ['title' => 'New Spot', 'user_id' => $user->id]);
        $response->assertRedirect(route('categories.index'));

    }

    public function test_show_displays_spot_details()
    {
        $user = User::factory()->create();
        $spot = Spot::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('spots.show', $spot));

        $response->assertStatus(200)
            ->assertInertia(fn ($page) => 
                $page->component('Spots/Show')
                    ->has('spot')
                    ->has('user')
            );
    }

    public function test_edit_displays_edit_form_for_authenticated_user()
    {
        $user = User::factory()->create();
        $spot = Spot::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('spots.edit', $spot));

        $response->assertStatus(200)
            ->assertInertia(fn ($page) => 
                $page->component('Spots/Edit')
                    ->has('spot')
                    ->has('maps')
                    ->has('characters')
            );
    }



    public function test_destroy_deletes_the_spot_and_redirects()
    {
        $user = User::factory()->create();
        $spot = Spot::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('spots.destroy', $spot));

        $this->assertDatabaseMissing('spots', ['id' => $spot->id]);
        $response->assertRedirect(route('spots.index'));
    }
}
