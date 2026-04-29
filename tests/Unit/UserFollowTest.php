<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFollowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_follow_another_user(): void
    {
        $user1 = User::create([
            'name' => 'User One',
            'username' => 'user1',
            'email' => 'user1@example.com',
            'password' => 'password'
        ]);

        $user2 = User::create([
            'name' => 'User Two',
            'username' => 'user2',
            'email' => 'user2@example.com',
            'password' => 'password'
        ]);

        $user1->follow($user2);

        $this->assertTrue($user1->isFollowing($user2));
        $this->assertDatabaseHas('follows', [
            'user_id' => $user1->id,
            'target_id' => $user2->id
        ]);
    }

    public function test_user_cannot_follow_themselves(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $user->follow($user);

        $this->assertFalse($user->isFollowing($user));
        $this->assertDatabaseMissing('follows', [
            'user_id' => $user->id,
            'target_id' => $user->id
        ]);
    }

    public function test_user_can_unfollow_another_user(): void
    {
        $user1 = User::create([
            'name' => 'User One',
            'username' => 'user1',
            'email' => 'user1@example.com',
            'password' => 'password'
        ]);

        $user2 = User::create([
            'name' => 'User Two',
            'username' => 'user2',
            'email' => 'user2@example.com',
            'password' => 'password'
        ]);

        $user1->follow($user2);
        $this->assertTrue($user1->isFollowing($user2));

        $user1->unfollow($user2);
        $this->assertFalse($user1->isFollowing($user2));
        $this->assertDatabaseMissing('follows', [
            'user_id' => $user1->id,
            'target_id' => $user2->id
        ]);
    }

    public function test_follow_is_idempotent(): void
    {
        $user1 = User::create([
            'name' => 'User One',
            'username' => 'user1',
            'email' => 'user1@example.com',
            'password' => 'password'
        ]);

        $user2 = User::create([
            'name' => 'User Two',
            'username' => 'user2',
            'email' => 'user2@example.com',
            'password' => 'password'
        ]);

        $user1->follow($user2);
        $user1->follow($user2); // Should not create duplicate

        $this->assertEquals(1, \App\Models\Follow::where('user_id', $user1->id)
            ->where('target_id', $user2->id)
            ->count());
    }
}
