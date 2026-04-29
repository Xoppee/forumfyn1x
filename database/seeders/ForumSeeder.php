<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Topic;
use App\Models\Pages;
use App\Models\Role;
use App\Models\Group;
use App\Models\GroupRole;
use App\Models\GroupMember;
use App\Models\Follow;
use App\Models\Reaction;
use App\Models\Post;
use App\Models\UserVerification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->command->info('🌱 Criando dados base do fórum...');

        $this->createRoles();
        $admin = $this->createAdmin();
        $this->createDefaultPages();
        $this->createPinnedTopic($admin);
        $this->createSampleTopics($admin);
        $this->createDefaultGroup($admin);

        $this->command->info('✅ Fórum seeded com sucesso!');
        $this->command->info('📧 Login: admin@fyn1x.com / password');
    }

    protected function createRoles(): void
    {
        $roles = [
            ['name' => 'Fundador', 'slug' => 'founder', 'icon' => 'crown', 'is_active' => true, 'permissions' => ['manage_users', 'manage_posts', 'manage_topics', 'manage_roles', 'manage_pages', 'manage_images', 'manage_archives', 'ban_users', 'delete_content', 'edit_content', 'view_admin', 'moderator']],
            ['name' => 'Administrador', 'slug' => 'admin', 'icon' => 'shield', 'is_active' => true, 'permissions' => ['manage_users', 'manage_posts', 'manage_topics', 'manage_roles', 'manage_pages', 'ban_users', 'delete_content', 'view_admin', 'moderator']],
            ['name' => 'Moderador', 'slug' => 'moderator', 'icon' => 'eye', 'is_active' => true, 'permissions' => ['manage_posts', 'manage_topics', 'ban_users', 'delete_content', 'moderator']],
            ['name' => 'Colaborador', 'slug' => 'contributor', 'icon' => 'edit-3', 'is_active' => true, 'permissions' => ['edit_content']],
            ['name' => 'Usuário', 'slug' => 'user', 'icon' => 'user', 'is_active' => true, 'permissions' => []],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(['slug' => $roleData['slug']], $roleData);
        }

        $this->command->info('   ✓ Roles criadas');
    }

    protected function createAdmin(): User
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@fyn1x.com'],
            [
                'name' => 'Fyn1x Admin',
                'username' => 'admin',
                'password' => 'password',
                'bio' => 'Criador e desenvolvedor do Fyn1x Forum.',
                'reputation' => 9999,
                'current_level' => 99,
                'is_banned' => false,
                'is_verified' => true,
            ]
        );

        $founderRole = Role::where('slug', 'founder')->first();
        $adminRole = Role::where('slug', 'admin')->first();

        if (!$admin->roles()->where('role_id', $founderRole->id)->exists()) {
            $admin->roles()->attach($founderRole->id, ['assigned_at' => now()]);
        }
        if (!$admin->roles()->where('role_id', $adminRole->id)->exists()) {
            $admin->roles()->attach($adminRole->id, ['assigned_at' => now()]);
        }

        UserVerification::firstOrCreate(
            ['user_id' => $admin->id],
            [
                'user_id' => $admin->id,
                'status' => 'approved',
                'posts_count' => 999,
                'followers_count' => 999,
                'reactions_count' => 9999,
            ]
        );

        $this->command->info('   ✓ Admin criado: admin@fyn1x.com / password');
        return $admin;
    }

    protected function createDefaultPages(): void
    {
        $pages = [
            ['title' => 'Início', 'slug' => 'inicio', 'icon' => 'home', 'content' => '', 'is_published' => true, 'index' => 1],
            ['title' => 'Regras', 'slug' => 'regras', 'icon' => 'book-open', 'content' => '', 'is_published' => true, 'index' => 2],
            ['title' => 'Sobre', 'slug' => 'sobre', 'icon' => 'info', 'content' => '', 'is_published' => true, 'index' => 3],
            ['title' => 'Contato', 'slug' => 'contato', 'icon' => 'mail', 'content' => '', 'is_published' => true, 'index' => 4],
        ];

        foreach ($pages as $pageData) {
            Pages::firstOrCreate(['slug' => $pageData['slug']], $pageData);
        }

        $this->command->info('   ✓ Páginas padrão criadas');
    }

    protected function createPinnedTopic(User $admin): void
    {
        $topic = Topic::firstOrCreate(
            ['slug' => 'boas-vindas-fyn1x-forum'],
            ['title' => 'Bem-vindo ao Fyn1x Forum!', 'user_id' => $admin->id, 'is_published' => true, 'is_sticky' => true]
        );

        if (!$topic->posts()->exists()) {
            $topic->posts()->create([
                'body' => "👋Olá e seja bem-vindo ao Fyn1x Forum!\n\nEste é um espaço construído para aprendizado, discussões e troca de conhecimento.\n\n**Regras básicas:**\n- Respeite todos os membros\n- Não faça spam\n- Use títulos claros\n- Procure antes de perguntar\n\nVamos construir uma comunidade incrível juntos! 🚀",
                'user_id' => $admin->id,
            ]);
        }

        $this->command->info('   ✓ Tópico fixo de boas-vindas criado');
    }

    protected function createSampleTopics(User $admin): void
    {
        $topicsData = [
            ['title' => 'Como contribuir com o projeto?', 'slug' => 'como-contribuir', 'body' => "Quer contribuir com o Fyn1x Forum?\n\nExistem várias formas:\n- Reportar bugs\n- Sugerir melhorias\n- Criar conteúdo\n- Compartilhar conhecimento\n\nTodas as contribuições são bem-vindas! 💡"],
            ['title' => 'Dúvidas sobre Laravel?', 'slug' => 'duvidas-laravel', 'body' => "Este é o espaço para tirar dúvidas sobre Laravel e PHP.\n\nClique em 'Criar Tópico' para fazer sua pergunta!"],
            ['title' => 'Showcase - MOSTRE SEUS PROJETOS', 'slug' => 'showcase-projetos', 'body' => "Mostre aqui seus projetos desenvolvidos!\n\nTodos adoram ver código funcionando. 🚀"],
        ];

        foreach ($topicsData as $topicData) {
            $topic = Topic::firstOrCreate(
                ['slug' => $topicData['slug']],
                ['title' => $topicData['title'], 'user_id' => $admin->id, 'is_published' => true]
            );

            if (!$topic->posts()->exists()) {
                $topic->posts()->create(['body' => $topicData['body'], 'user_id' => $admin->id]);
            }
        }

        $this->command->info('   ✓ Tópicos de exemple criados');
    }

    protected function createDefaultGroup(User $admin): void
    {
        $group = Group::firstOrCreate(
            ['slug' => 'fyn1x-oficial'],
            [
                'name' => 'Fyn1x Oficial',
                'description' => 'Grupo oficial do Fyn1x Forum. Espacio para discussões gerais e suporte.',
                'is_private' => false,
                'is_verified' => true,
                'creator_id' => $admin->id,
            ]
        );

        $adminRole = GroupRole::firstOrCreate(
            ['group_id' => $group->id, 'slug' => 'admin'],
            [
                'group_id' => $group->id,
                'name' => 'Administrador',
                'slug' => 'admin',
                'color' => '#ef4444',
                'level' => 100,
                'can_manage' => true,
                'can_kick' => true,
                'can_edit' => true,
                'can_delete' => true,
                'can_moderate' => true,
            ]
        );

        $memberRole = GroupRole::firstOrCreate(
            ['group_id' => $group->id, 'slug' => 'member'],
            [
                'group_id' => $group->id,
                'name' => 'Membro',
                'slug' => 'member',
                'color' => '#6b7280',
                'level' => 10,
                'can_manage' => false,
                'can_kick' => false,
                'can_edit' => false,
                'can_delete' => false,
                'can_moderate' => false,
            ]
        );

        GroupMember::firstOrCreate(
            ['group_id' => $group->id, 'user_id' => $admin->id],
            [
                'group_id' => $group->id,
                'user_id' => $admin->id,
                'group_role_id' => $adminRole->id,
                'status' => 'approved',
            ]
        );

        $this->command->info('   ✓ Grupo oficial criado com admin como membro');
    }
}