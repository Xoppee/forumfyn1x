<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FollowsController extends Controller
{
    public function follow(User $user): JsonResponse
    {
        $currentUser = auth()->user();

        if ($currentUser->id === $user->id) {
            return response()->json(['error' => 'Você não pode seguir a si mesmo.'], 400);
        }

        $existingFollow = Follow::where('user_id', $currentUser->id)
            ->where('target_id', $user->id)
            ->first();

        if ($existingFollow) {
            return response()->json(['error' => 'Você já segue este usuário.'], 400);
        }

        Follow::create([
            'user_id' => $currentUser->id,
            'target_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Você agora segue ' . $user->name
        ]);
    }

    public function unfollow(User $user): JsonResponse
    {
        $currentUser = auth()->user();

        $follow = Follow::where('user_id', $currentUser->id)
            ->where('target_id', $user->id)
            ->first();

        if (!$follow) {
            return response()->json(['error' => 'Você não segue este usuário.'], 400);
        }

        $follow->delete();

        return response()->json([
            'success' => true,
            'message' => 'Você deixou de seguir ' . $user->name
        ]);
    }

    public function followers(User $user): JsonResponse
    {
        $followers = Follow::where('target_id', $user->id)
            ->with('user')
            ->get()
            ->map(fn($follow) => $follow->user);

        return response()->json(['followers' => $followers]);
    }

    public function following(User $user): JsonResponse
    {
        $following = Follow::where('user_id', $user->id)
            ->with('target')
            ->get()
            ->map(fn($follow) => $follow->target);

        return response()->json(['following' => $following]);
    }

    public function isFollowing(User $user): JsonResponse
    {
        $currentUser = auth()->user();
        
        $isFollowing = Follow::where('user_id', $currentUser->id)
            ->where('target_id', $user->id)
            ->exists();

        return response()->json(['is_following' => $isFollowing]);
    }
}