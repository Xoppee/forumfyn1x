<?php

namespace Tests\Unit;

use App\Models\Topic;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTopicTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_topic(): void
    {
        $topic = Topic::create([
            'title' => 'Test Topic',
            'slug' => 'test-topic',
            'is_published' => true
        ]);

        $this->assertDatabaseHas('topics', [
            'title' => 'Test Topic'
        ]);
    }

    public function test_can_toggle_topic_published_status(): void
    {
        $topic = Topic::create([
            'title' => 'Test Topic',
            'slug' => 'test-topic',
            'is_published' => true
        ]);

        $this->assertTrue($topic->is_published);

        $topic->update(['is_published' => false]);
        $this->assertFalse($topic->fresh()->is_published);
    }

    public function test_can_delete_topic(): void
    {
        $topic = Topic::create([
            'title' => 'Test Topic',
            'slug' => 'test-topic'
        ]);

        $topicId = $topic->id;
        $topic->delete();

        $this->assertSoftDeleted('topics', ['id' => $topicId]);
    }

    public function test_topic_belongs_to_user(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'topicuser',
            'email' => 'topic-test@example.com',
            'password' => 'password'
        ]);

        $topic = Topic::create([
            'title' => 'Test Topic',
            'slug' => 'test-topic',
            'user_id' => $user->id
        ]);

        $this->assertEquals($user->id, $topic->user_id);
    }

    public function test_topic_has_many_posts(): void
    {
        $topic = Topic::create([
            'title' => 'Test Topic',
            'slug' => 'test-topic'
        ]);

        $user = User::create([
            'name' => 'Test User',
            'username' => 'postuser',
            'email' => 'post-test@example.com',
            'password' => 'password'
        ]);

        Post::create([
            'body' => 'Test Post 1',
            'topic_id' => $topic->id,
            'user_id' => $user->id
        ]);

        Post::create([
            'body' => 'Test Post 2',
            'topic_id' => $topic->id,
            'user_id' => $user->id
        ]);

        $this->assertCount(2, $topic->posts);
    }
}