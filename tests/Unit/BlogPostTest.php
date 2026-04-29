<?php

namespace Tests\Unit;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_blog_post(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $post = BlogPost::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'user_id' => $user->id,
            'template_id' => 'blog-post',
            'title' => 'My First Blog Post',
            'slug' => 'my-first-blog-post',
            'content' => 'This is the content of my blog post.',
            'summary' => 'A short summary',
            'meta_fields' => ['category' => 'Technology'],
            'is_published' => true,
        ]);

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'My First Blog Post',
            'template_id' => 'blog-post',
            'user_id' => $user->id
        ]);
    }

    public function test_blog_post_belongs_to_user(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $post = BlogPost::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'user_id' => $user->id,
            'template_id' => 'blog-post',
            'title' => 'Test Post',
            'slug' => 'test-post',
            'content' => 'Content here',
            'is_published' => false,
        ]);

        $this->assertEquals($user->id, $post->user->id);
    }

    public function test_meta_fields_are_cast_to_array(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $metaFields = ['category' => 'Tech', 'difficulty' => 'Beginner'];
        $post = BlogPost::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'user_id' => $user->id,
            'template_id' => 'tutorial',
            'title' => 'Test Post',
            'slug' => 'test-post',
            'content' => 'Content',
            'meta_fields' => $metaFields,
            'is_published' => true,
        ]);

        $this->assertIsArray($post->meta_fields);
        $this->assertEquals('Tech', $post->meta_fields['category']);
    }

    public function test_is_published_is_boolean(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $post = BlogPost::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'user_id' => $user->id,
            'template_id' => 'blog-post',
            'title' => 'Test',
            'slug' => 'test',
            'content' => 'Content',
            'is_published' => 1,
        ]);

        $this->assertTrue($post->is_published);
    }
}
