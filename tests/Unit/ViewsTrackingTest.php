<?php

namespace Tests\Unit;

use App\Models\ProfileViews;
use App\Models\TopicViews;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewsTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_view_is_tracked(): void
    {
        $user1 = User::create([
            'name' => 'Profile Owner',
            'username' => 'owner',
            'email' => 'owner@example.com',
            'password' => 'password'
        ]);

        $viewer = User::create([
            'name' => 'Viewer',
            'username' => 'viewer',
            'email' => 'viewer@example.com',
            'password' => 'password'
        ]);

        $this->actingAs($viewer);
        $response = $this->get('/profile/' . $user1->username);

        $response->assertStatus(200);
        $this->assertDatabaseHas('profile_views', [
            'user_id' => $user1->id,
            'visitor_id' => $viewer->id
        ]);
    }

    public function test_profile_view_is_not_tracked_for_own_profile(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $this->actingAs($user);
        $response = $this->get('/profile/' . $user->username);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('profile_views', [
            'user_id' => $user->id,
            'visitor_id' => $user->id
        ]);
    }

    public function test_profile_view_is_not_tracked_for_guests(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response = $this->get('/profile/' . $user->username);

        $response->assertStatus(200);
        $this->assertDatabaseCount('profile_views', 0);
    }

    public function test_topic_view_is_tracked(): void
    {
        $author = User::create([
            'name' => 'Author',
            'username' => 'author',
            'email' => 'author@example.com',
            'password' => 'password'
        ]);

        $viewer = User::create([
            'name' => 'Viewer',
            'username' => 'viewer',
            'email' => 'viewer@example.com',
            'password' => 'password'
        ]);

        $topic = \App\Models\Topic::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'title' => 'Test Topic',
            'slug' => 'test-topic',
            'user_id' => $author->id,
            'is_published' => true,
        ]);

        $this->actingAs($viewer);
        $response = $this->get('/topics/' . $topic->slug);

        $response->assertStatus(200);
        $this->assertDatabaseHas('topic_views', [
            'topic_id' => $topic->id,
            'user_id' => $viewer->id
        ]);
    }

    public function test_topic_view_is_not_tracked_for_guests(): void
    {
        $author = User::create([
            'name' => 'Author',
            'username' => 'author',
            'email' => 'author@example.com',
            'password' => 'password'
        ]);

        $topic = \App\Models\Topic::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'title' => 'Test Topic',
            'slug' => 'test-topic',
            'user_id' => $author->id,
            'is_published' => true,
        ]);

        $response = $this->get('/topics/' . $topic->slug);

        $response->assertStatus(200);
        $this->assertDatabaseCount('topic_views', 0);
    }

    public function test_profile_view_prevents_duplicates(): void
    {
        $user = User::create([
            'name' => 'Profile Owner',
            'username' => 'owner',
            'email' => 'owner@example.com',
            'password' => 'password'
        ]);

        $viewer = User::create([
            'name' => 'Viewer',
            'username' => 'viewer',
            'email' => 'viewer@example.com',
            'password' => 'password'
        ]);

        $this->actingAs($viewer);
        
        // First view
        $this->get('/profile/' . $user->username);
        
        // Second view (should not create duplicate)
        $this->get('/profile/' . $user->username);

        $this->assertDatabaseCount('profile_views', 1);
    }
}
