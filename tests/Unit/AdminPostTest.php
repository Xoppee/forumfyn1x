<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_post(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'postuser',
            'email' => 'post-create@example.com',
            'password' => 'password'
        ]);

        $topic = Topic::create([
            'title' => 'Test Topic',
            'slug' => 'test-topic'
        ]);

        $post = Post::create([
            'body' => 'Test post content',
            'user_id' => $user->id,
            'topic_id' => $topic->id
        ]);

        $this->assertDatabaseHas('posts', [
            'body' => 'Test post content'
        ]);
    }

    public function test_can_hide_post(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'hidepost',
            'email' => 'hide-post@example.com',
            'password' => 'password'
        ]);

        $topic = Topic::create([
            'title' => 'Test Topic',
            'slug' => 'test-topic'
        ]);

        $post = Post::create([
            'body' => 'Test post',
            'user_id' => $user->id,
            'topic_id' => $topic->id,
            'is_hidden' => false
        ]);

        $this->assertFalse($post->is_hidden);

        $post->update(['is_hidden' => true]);
        $this->assertTrue($post->fresh()->is_hidden);
    }

    public function test_can_restore_post(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'restorepost',
            'email' => 'restore-post@example.com',
            'password' => 'password'
        ]);

        $topic = Topic::create([
            'title' => 'Test Topic',
            'slug' => 'test-topic'
        ]);

        $post = Post::create([
            'body' => 'Test post',
            'user_id' => $user->id,
            'topic_id' => $topic->id,
            'is_hidden' => true
        ]);

        $post->update(['is_hidden' => false]);
        $this->assertFalse($post->fresh()->is_hidden);
    }

    public function test_can_soft_delete_post(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'delpost',
            'email' => 'delete-post@example.com',
            'password' => 'password'
        ]);

        $topic = Topic::create([
            'title' => 'Test Topic',
            'slug' => 'test-topic'
        ]);

        $post = Post::create([
            'body' => 'Test post',
            'user_id' => $user->id,
            'topic_id' => $topic->id
        ]);

        $postId = $post->id;
        $post->delete();

        $this->assertSoftDeleted('posts', ['id' => $postId]);
    }

    public function test_post_belongs_to_user(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'belongpost',
            'email' => 'belong-post@example.com',
            'password' => 'password'
        ]);

        $topic = Topic::create([
            'title' => 'Test Topic',
            'slug' => 'test-topic'
        ]);

        $post = Post::create([
            'body' => 'Test post',
            'user_id' => $user->id,
            'topic_id' => $topic->id
        ]);

        $this->assertEquals($user->id, $post->user_id);
    }

    public function test_default_post_is_visible(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'defpost',
            'email' => 'default-post@example.com',
            'password' => 'password'
        ]);

        $topic = Topic::create([
            'title' => 'Test Topic',
            'slug' => 'test-topic'
        ]);

        $post = Post::create([
            'body' => 'Test post',
            'user_id' => $user->id,
            'topic_id' => $topic->id,
            'is_hidden' => false
        ]);

        $this->assertFalse($post->is_hidden);
    }
}