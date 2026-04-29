<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    
    public function index($u)
    {
        $user = \App\Models\User::where('username', $u)->firstOrFail();
        $posts = \App\Models\Post::where('user_id', $user->id)->latest()->get();
        $followers = $user->followers()->count();
        $following = $user->following()->count();
        $pages = \App\Models\Pages::orderBy('index', 'ASC')->get();

        if (auth()->check() && auth()->id() !== $user->id) {
            \App\Models\ProfileViews::firstOrCreate([
                'user_id' => $user->id,
                'visitor_id' => auth()->id(),
            ]);
        }

        return view('profile.index', compact('user', 'posts', 'followers', 'following', 'pages'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
            $user->cover = $coverPath;
        }

        $user->save();

        return redirect()->route('profile', ['username' => $user->username])->with('success', 'Profile updated successfully.');
    }

    public function follow($u)
    {
        $userToFollow = \App\Models\User::where('username', $u)->firstOrFail();
        $user = auth()->user();

        if ($user->id === $userToFollow->id) {
            return redirect()->back()->with('error', 'Você não pode seguir a si mesmo.');
        }

        $user->follow($userToFollow);

        return redirect()->back()->with('success', 'Você agora segue ' . $userToFollow->username . '.');
    }

    public function unfollow($u)
    {
        $userToUnfollow = \App\Models\User::where('username', $u)->firstOrFail();
        $user = auth()->user();

        $user->unfollow($userToUnfollow);

        return redirect()->back()->with('success', 'Você deixou de seguir ' . $userToUnfollow->username . '.');
    }

    public function enableBlog(\App\Http\Requests\EnableBlogRequest $request)
    {
        $user = auth()->user();
        $user->enableBlog($request->description);
        return redirect()->back()->with('success', 'Blog ativado com sucesso!');
    }

    public function disableBlog()
    {
        $user = auth()->user();
        $user->disableBlog();
        return redirect()->back()->with('success', 'Blog desativado com sucesso!');
    }

}
