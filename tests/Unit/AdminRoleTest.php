<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use App\Models\Topic;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_role(): void
    {
        $role = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'icon' => 'shield',
            'is_active' => true,
            'permissions' => ['manage_users', 'manage_posts']
        ]);

        $this->assertDatabaseHas('roles', [
            'name' => 'Admin',
            'slug' => 'admin'
        ]);
    }

    public function test_role_has_permissions_as_array(): void
    {
        $role = Role::create([
            'name' => 'Moderator',
            'slug' => 'moderator',
            'permissions' => ['manage_posts', 'ban_users']
        ]);

        $this->assertIsArray($role->permissions);
        $this->assertContains('manage_posts', $role->permissions);
    }

    public function test_can_assign_role_to_user(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $role = Role::create([
            'name' => 'Admin',
            'slug' => 'admin'
        ]);

        $user->roles()->attach($role->id, ['assigned_at' => now()]);

        $this->assertTrue($user->roles->contains($role->id));
    }

    public function test_can_remove_role_from_user(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser2',
            'email' => 'test2@example.com',
            'password' => 'password'
        ]);

        $role = Role::create([
            'name' => 'Admin',
            'slug' => 'admin'
        ]);

        $user->roles()->attach($role->id, ['assigned_at' => now()]);
        $user->roles()->detach($role->id);

        $this->assertFalse($user->roles->contains($role->id));
    }

    public function test_user_can_have_multiple_roles(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser3',
            'email' => 'test3@example.com',
            'password' => 'password'
        ]);

        $role1 = Role::create(['name' => 'Admin', 'slug' => 'admin']);
        $role2 = Role::create(['name' => 'Moderator', 'slug' => 'moderator']);

        $user->roles()->attach($role1->id, ['assigned_at' => now()]);
        $user->roles()->attach($role2->id, ['assigned_at' => now()]);

        $this->assertCount(2, $user->roles);
    }

    public function test_can_toggle_role_active_status(): void
    {
        $role = Role::create([
            'name' => 'Test Role',
            'slug' => 'test-role',
            'is_active' => true
        ]);

        $this->assertTrue($role->is_active);

        $role->update(['is_active' => false]);
        $this->assertFalse($role->fresh()->is_active);
    }
}