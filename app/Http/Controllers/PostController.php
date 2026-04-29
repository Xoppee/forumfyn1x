<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    
    public function store(StorePostRequest $request)
    {
        $post = Post::create([
            'topic_id' => $request->input('topic_id'),
            'body' => $request->input('body'),
            'user_id' => auth()->id()
        ]);

        return redirect()->route('topics.show', $post->topic->slug);
    }

    public function edit(Post $post)
    {
        if($post->user_id !== auth()->id()) {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        if($post->user_id !== auth()->id()) {
            abort(403);
        }

        $post->update([
            'body' => $request->input('body'),
            'is_edited' => true,
            'old_post' => $post->body
        ]);

        return redirect()->route('topics.show', $post->topic->slug);
    }

    public function destroy(Post $post)
    {
        if($post->user_id !== auth()->id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('topics.show', $post->topic_id);
    }
    
 
}
