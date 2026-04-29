<?php

namespace Tests\Unit;

use App\Models\Reaction;
use App\Models\Topic;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReactionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_reaction_to_post(): void
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
            'user_id' => $user->id,
            'is_published' => true,
        ]);

        $post = Post::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'topic_id' => $topic->id,
            'user_id' => $user->id,
            'body' => 'Test content',
        ]);

        $this->actingAs($user);

        $response = $this->postJson('/reactions/toggle', [
            'reactionable_id' => $post->id,
            'reactionable_type' => 'post',
            'type' => 'like'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'action' => 'added']);
        $this->assertDatabaseHas('reactions', [
            'user_id' => $user->id,
            'reactionable_id' => $post->id,
            'reactionable_type' => 'App\Models\Post',
            'type' => 'like'
        ]);
    }

    public function test_user_can_remove_reaction(): void
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
            'user_id' => $user->id,
            'is_published' => true,
        ]);

        $post = Post::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'topic_id' => $topic->id,
            'user_id' => $user->id,
            'body' => 'Test content',
        ]);

        Reaction::create([
            'user_id' => $user->id,
            'reactionable_id' => $post->id,
            'reactionable_type' => 'App\Models\Post',
            'type' => 'like'
        ]);

        $this->actingAs($user);

        $response = $this->postJson('/reactions/toggle', [
            'reactionable_id' => $post->id,
            'reactionable_type' => 'post',
            'type' => 'like'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'action' => 'removed']);
        $this->assertDatabaseMissing('reactions', [
            'user_id' => $user->id,
            'reactionable_id' => $post->id,
        ]);
    }

    public function test_user_can_update_reaction(): void
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
            'user_id' => $user->id,
            'is_published' => true,
        ]);

        $post = Post::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'topic_id' => $topic->id,
            'user_id' => $user->id,
            'body' => 'Test content',
        ]);

        Reaction::create([
            'user_id' => $user->id,
            'reactionable_id' => $post->id,
            'reactionable_type' => 'App\Models\Post',
            'type' => 'like'
        ]);

        $this->actingAs($user);

        $response = $this->postJson('/reactions/toggle', [
            'reactionable_id' => $post->id,
            'reactionable_type' => 'post',
            'type' => 'love'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true, 'action' => 'updated']);
        $this->assertDatabaseHas('reactions', [
            'user_id' => $user->id,
            'reactionable_id' => $post->id,
            'type' => 'love'
        ]);
    }

    public function test_user_can_get_reactions_for_post(): void
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
            'user_id' => $user->id,
            'is_published' => true,
        ]);

        $post = Post::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'topic_id' => $topic->id,
            'user_id' => $user->id,
            'body' => 'Test content',
        ]);

        Reaction::create([
            'user_id' => $user->id,
            'reactionable_id' => $post->id,
            'reactionable_type' => 'App\Models\Post',
            'type' => 'like'
        ]);

        $this->actingAs($user);

        $response = $this->getJson('/reactions?reactionable_id=' . $post->id . '&reactionable_type=post');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'reactions',
            'user_reaction',
            'total'
        ]);
        $response->assertJson(['user_reaction' => 'like', 'total' => 1]);
    }

    public function test_guest_cannot_toggle_reaction(): void
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
            'user_id' => $user->id,
            'is_published' => true,
        ]);

        $post = Post::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'topic_id' => $topic->id,
            'user_id' => $user->id,
            'body' => 'Test content',
        ]);

        $response = $this->postJson('/reactions/toggle', [
            'reactionable_id' => $post->id,
            'reactionable_type' => 'post',
            'type' => 'like'
        ]);

        $response->assertStatus(401);
    }
}
