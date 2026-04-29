<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_middleware_allows_admin(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'password'
        ]);

        $admin->roles()->create([
            'id' => \Illuminate\Support\Str::uuid(),
            'name' => 'Admin',
            'slug' => 'admin',
            'icon' => 'shield',
            'is_active' => true,
            'permissions' => []
        ]);

        $this->actingAs($admin);
        $response = $this->get('/admin');

        $response->assertStatus(200);
    }

    public function test_admin_middleware_blocks_non_admin(): void
    {
        $user = User::create([
            'name' => 'Regular User',
            'username' => 'regular',
            'email' => 'regular@example.com',
            'password' => 'password'
        ]);

        $this->actingAs($user);
        $response = $this->get('/admin');

        $response->assertRedirect('/');
        $response->assertSessionHas('error', 'Acesso não autorizado.');
    }

    public function test_admin_middleware_blocks_guest(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/auth');
    }

    public function test_admin_can_create_topic(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => 'password'
        ]);

        $admin->roles()->create([
            'id' => \Illuminate\Support\Str::uuid(),
            'name' => 'Admin',
            'slug' => 'admin',
            'icon' => 'shield',
            'is_active' => true,
            'permissions' => []
        ]);

        $this->actingAs($admin);
        $response = $this->post('/topics', [
            'title' => 'Test Topic by Admin'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('topics', [
            'title' => 'Test Topic by Admin',
            'user_id' => $admin->id
        ]);
    }

    public function test_non_admin_cannot_create_topic(): void
    {
        $user = User::create([
            'name' => 'Regular User',
            'username' => 'regular',
            'email' => 'regular@example.com',
            'password' => 'password'
        ]);

        $this->actingAs($user);
        $response = $this->post('/topics', [
            'title' => 'Should Not Work'
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('error', 'Acesso não autorizado.');
    }
}
