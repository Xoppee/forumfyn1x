<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTopicRequest;
use App\Models\Topic;
use App\Models\Pages;

class TopicController extends Controller
{
    public function list()
    {
        $topics = Topic::where('is_published', true)
            ->with(['posts', 'user'])
            ->orderBy('is_sticky', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->paginate(20);
        return view('topics.list', compact('topics'));
    }

    public function index($t)
    {
        $topic = Topic::with(['posts', 'posts.user', 'posts.user.roles', 'tags'])->where('slug', $t)->firstOrFail();

        if (auth()->check()) {
            \App\Models\TopicViews::firstOrCreate([
                'topic_id' => $topic->id,
                'user_id' => auth()->id(),
            ]);
        }

        return view('topics.show', compact('topic'));
    }

    public function create()
    {
        $pages = Pages::where('is_published', true)->get();
        return view('topics.create', compact('pages'));
    }

    public function createForGroup(\App\Models\Group $group)
    {
        return view('topics.create-group', compact('group'));
    }

    public function store(StoreTopicRequest $request)
    {
        $topic = Topic::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'title' => $request->input('title'),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('topics.show', $topic->slug);
    }

    public function storeForGroup(\Illuminate\Http\Request $request, \App\Models\Group $group)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();
        
        $topic = Topic::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'title' => $request->title,
            'user_id' => $user->id,
            'group_id' => $group->id,
            'is_published' => true,
        ]);

        \App\Models\Post::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'body' => $request->body,
            'user_id' => $user->id,
            'topic_id' => $topic->id,
        ]);

        return redirect()->route('topics.show', $topic->slug);
    }
}
