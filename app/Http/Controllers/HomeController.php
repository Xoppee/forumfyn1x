<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function index()
    {
        $posts = \App\Models\Post::with('user')->latest()->get();
        $users = \App\Models\User::get();
        $pages = \App\Models\Pages::orderBy('index', 'ASC')->get();
        $topic = \App\Models\Topic::where('is_sticky', true)->withCount('posts')->first();
        return view('welcome', compact('posts', 'users', 'pages', 'topic'));
    }

}
