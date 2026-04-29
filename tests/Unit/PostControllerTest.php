<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_post(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $topic = Topic::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'title' => 'Test Topic',
            'slug' => 'test-topic',
            'user_id' => $user->id,
            'is_published' => true,
        ]);

        $this->actingAs($user);
        $response = $this->post('/posts', [
            'topic_id' => $topic->id,
            'body' => 'This is a test post content.'
        ]);

        $response->assertRedirect('/topics/' . $topic->slug);
        $this->assertDatabaseHas('posts', [
            'topic_id' => $topic->id,
            'user_id' => $user->id,
            'body' => 'This is a test post content.'
        ]);
    }

    public function test_post_redirects_to_topic_not_post_show(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $topic = Topic::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'title' => 'Test Topic',
            'slug' => 'test-topic',
            'user_id' => $user->id,
            'is_published' => true,
        ]);

        $post = Post::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'topic_id' => $topic->id,
            'user_id' => $user->id,
            'body' => 'Original content'
        ]);

        $this->actingAs($user);
        $response = $this->put('/posts/' . $post->id, [
            'body' => 'Updated content'
        ]);

        $response->assertRedirect('/topics/' . $topic->slug);
    }

    public function test_user_can_only_edit_own_post(): void
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

        $topic = Topic::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'title' => 'Test Topic',
            'slug' => 'test-topic',
            'user_id' => $user1->id,
            'is_published' => true,
        ]);

        $post = Post::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'topic_id' => $topic->id,
            'user_id' => $user1->id,
            'body' => 'Original content'
        ]);

        $this->actingAs($user2);
        $response = $this->put('/posts/' . $post->id, [
            'body' => 'Hacked content'
        ]);

        $response->assertStatus(403);
    }

    public function test_post_update_saves_old_content(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $topic = Topic::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'title' => 'Test Topic',
            'slug' => 'test-topic',
            'user_id' => $user->id,
            'is_published' => true,
        ]);

        $post = Post::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'topic_id' => $topic->id,
            'user_id' => $user->id,
            'body' => 'Original content'
        ]);

        $this->actingAs($user);
        $this->put('/posts/' . $post->id, [
            'body' => 'Updated content'
        ]);

        $post->refresh();
        $this->assertEquals('Updated content', $post->body);
        $this->assertEquals('Original content', $post->old_post);
        $this->assertTrue($post->is_edited);
    }
}
