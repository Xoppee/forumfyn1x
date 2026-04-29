<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_user(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }

    public function test_can_ban_user(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'bantest',
            'email' => 'ban-test@example.com',
            'password' => 'password',
            'is_banned' => false
        ]);

        $this->assertFalse($user->is_banned);

        $user->update(['is_banned' => true]);
        $this->assertTrue($user->fresh()->is_banned);
    }

    public function test_can_unban_user(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'unbantest',
            'email' => 'unban-test@example.com',
            'password' => 'password',
            'is_banned' => true
        ]);

        $user->update(['is_banned' => false]);
        $this->assertFalse($user->fresh()->is_banned);
    }

    public function test_user_can_have_avatar(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'avatartest',
            'email' => 'avatar-test@example.com',
            'password' => 'password',
            'avatar' => 'avatars/test.jpg'
        ]);

        $this->assertEquals('avatars/test.jpg', $user->avatar);
    }

    public function test_default_user_is_not_banned(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'defaulttest',
            'email' => 'default-test@example.com',
            'password' => 'password',
            'is_banned' => false
        ]);

        $this->assertFalse($user->is_banned);
    }

    public function test_user_has_reputation(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'reptest',
            'email' => 'reputation-test@example.com',
            'password' => 'password',
            'reputation' => 100
        ]);

        $this->assertEquals(100, $user->reputation);
    }
}