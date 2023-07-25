<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\User;

class UserRegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    /** @test */
    public function a_user_is_created_with_default_categories()
    {
        // テスト用のユーザーデータを作成
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        // ユーザー登録のリクエストを送信
        $this->post('/register', $userData);

        // データベースからユーザーを取得
        $user = User::where('email', $userData['email'])->first();

        // ユーザーが作成されている
        $this->assertNotNull($user);

        // ユーザーに紐づくカテゴリーを取得
        $categories = $user->categories;

        // デフォルトのカテゴリーが作成されている
        $this->assertContains('Aサイト', $categories->pluck('name'));
        $this->assertContains('Bサイト', $categories->pluck('name'));
        $this->assertContains('Cサイト', $categories->pluck('name'));
    }
}
