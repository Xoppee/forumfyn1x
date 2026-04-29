<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $topics = collect();
        $posts = collect();
        $users = collect();

        if (strlen($query) >= 2) {
            $topics = Topic::where('title', 'LIKE', "%{$query}%")
                ->with('user')
                ->where('is_published', true)
                ->limit(10)
                ->get();

            $posts = Post::where('body', 'LIKE', "%{$query}%")
                ->with('user', 'topic')
                ->limit(10)
                ->get();

            $users = User::where('name', 'LIKE', "%{$query}%")
                ->orWhere('username', 'LIKE', "%{$query}%")
                ->limit(10)
                ->get();
        }

        if ($request->expectsJson()) {
            return response()->json([
                'topics' => $topics,
                'posts' => $posts,
                'users' => $users,
            ]);
        }

        return view('search.results', compact('query', 'topics', 'posts', 'users'));
    }
}
