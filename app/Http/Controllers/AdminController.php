<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use App\Models\Topic;
use App\Models\Image;
use App\Models\Archive;
use App\Models\Role;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\AssignRoleRequest;
use App\Http\Requests\BanUserRequest;

class AdminController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::with('roles')->latest()->paginate(20);
        $posts = \App\Models\Post::with('user')->latest()->paginate(20);
        $pages = \App\Models\Pages::orderBy('index', 'ASC')->get();

        return view('admin.index', compact('users', 'posts', 'pages'));
    }

    public function users()
    {
        $users = \App\Models\User::with('roles')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function topics()
    {
        $topics = Topic::with('posts', 'user')->latest()->paginate(20);
        $posts = \App\Models\Post::with('user', 'topic')->latest()->paginate(20);
        return view('admin.topics.index', compact('topics', 'posts'));
    }

    public function roles()
    {
        $users = \App\Models\User::with('roles')->latest()->paginate(20);
        $roles = Role::with('users')->get();
        return view('admin.roles.index', compact('users', 'roles'));
    }

    public function images()
    {
        $images = Image::latest()->paginate(20);
        return view('admin.images.index', compact('images'));
    }

    public function archives()
    {
        $archives = Archive::latest()->paginate(20);
        return view('admin.archives.index', compact('archives'));
    }

    public function createPage(StorePageRequest $request)
    {
        $page = \App\Models\Pages::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'icon' => $request->icon,
            'content' => $request->content,
            'index' => \App\Models\Pages::max('index') + 1,
            'is_published' => $request->is_published,
        ]);

        return redirect()->route('admin')->with('success', 'Page created successfully.');
    }

    public function destroy(Pages $page)
    {
        $page->delete();
        return redirect()->back()->with('success', 'Página removida.');
    }

    public function banUser(BanUserRequest $request, \App\Models\User $user)
    {
        $user->update(['is_banned' => $request->is_banned]);
        return redirect()->back()->with('success', $request->is_banned ? 'Usuário banido.' : 'Usuário desbanido.');
    }

    public function togglePost(\Illuminate\Http\Request $request, \App\Models\Post $post)
    {
        $post->update(['is_hidden' => $request->is_hidden]);
        return redirect()->back()->with('success', $request->is_hidden ? 'Post oculto.' : 'Post restaurado.');
    }

    public function deletePost(\App\Models\Post $post)
    {
        $post->delete();
        return redirect()->back()->with('success', 'Post removido.');
    }

    public function toggleRole(\Illuminate\Http\Request $request, Role $role)
    {
        $role->update(['is_active' => $request->is_active]);
        return redirect()->back()->with('success', $request->is_active ? 'Role ativada.' : 'Role desativada.');
    }

    public function storeRole(StoreRoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'icon' => $request->icon ?? 'shield',
            'color' => $request->color,
            'is_active' => true,
            'permissions' => $request->permissions ?? [],
        ]);

        if ($request->has('user_ids') && is_array($request->user_ids)) {
            foreach ($request->user_ids as $userId) {
                $user = \App\Models\User::find($userId);
                if ($user) {
                    $user->roles()->attach($role->id, ['assigned_at' => now()]);
                }
            }
        }

        return redirect()->back()->with('success', 'Role criada com sucesso.');
    }

    public function assignRole(AssignRoleRequest $request, \App\Models\User $user)
    {
        if (!$user->roles()->where('role_id', $request->role_id)->exists()) {
            $user->roles()->attach($request->role_id, ['assigned_at' => now()]);
        }

        return redirect()->back()->with('success', 'Role atribuída ao usuário.');
    }

    public function removeRole(\App\Models\User $user, Role $role)
    {
        $user->roles()->detach($role->id);
        return redirect()->back()->with('success', 'Role removida do usuário.');
    }

    public function deleteRole(Role $role)
    {
        $role->delete();
        return redirect()->back()->with('success', 'Role removida.');
    }

    public function storeTopic(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $topic = Topic::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title),
        ]);

        return redirect()->route('admin.topics')->with('success', 'Tópico criado com sucesso.');
    }

    public function toggleTopic(\Illuminate\Http\Request $request, Topic $topic)
    {
        $topic->update(['is_published' => $request->is_published]);
        return redirect()->back()->with('success', $request->is_published ? 'Tópico publicado.' : 'Tópico despublicado.');
    }

    public function deleteTopic(Topic $topic)
    {
        $topic->delete();
        return redirect()->back()->with('success', 'Tópico removido.');
    }

    public function deleteImage(Image $image)
    {
        $image->delete();
        return redirect()->back()->with('success', 'Imagem removida.');
    }

    public function deleteArchive(Archive $archive)
    {
        $archive->delete();
        return redirect()->back()->with('success', 'Arquivo removido.');
    }

}
