<?php

namespace Tests\Unit;

use App\Models\Topic;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_returns_empty_for_short_query(): void
    {
        $response = $this->get('/search?q=a');

        $response->assertStatus(200);
        $response->assertSee('Digite pelo menos 2 caracteres');
    }

    public function test_search_finds_topics_by_title(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $topic = Topic::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'title' => 'How to optimize Laravel queries',
            'user_id' => $user->id,
            'is_published' => true,
        ]);

        $response = $this->get('/search?q=Laravel');

        $response->assertStatus(200);
        $response->assertSee('How to optimize Laravel queries');
    }

    public function test_search_finds_posts_by_content(): void
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

        Post::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'topic_id' => $topic->id,
            'user_id' => $user->id,
            'body' => 'This is a post about Laravel optimization',
        ]);

        $response = $this->get('/search?q=Laravel');

        $response->assertStatus(200);
        $response->assertSee('Laravel optimization');
    }

    public function test_search_finds_users_by_name(): void
    {
        User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => 'password'
        ]);

        $response = $this->get('/search?q=John');

        $response->assertStatus(200);
        $response->assertSee('John Doe');
    }

    public function test_search_finds_users_by_username(): void
    {
        User::create([
            'name' => 'Jane Doe',
            'username' => 'janedoe',
            'email' => 'jane@example.com',
            'password' => 'password'
        ]);

        $response = $this->get('/search?q=jane');

        $response->assertStatus(200);
        $response->assertSee('janedoe');
    }

    public function test_search_returns_json_for_api(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response = $this->getJson('/search?q=Test');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'topics',
            'posts',
            'users'
        ]);
    }
}
