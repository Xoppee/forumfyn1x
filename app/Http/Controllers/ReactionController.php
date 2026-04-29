<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReactionController extends Controller
{
    public function toggle(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'reactionable_id' => 'required|uuid',
            'reactionable_type' => 'required|string|in:topic,post',
            'type' => 'required|string|in:like,love,laugh,wow,sad,angry',
        ]);

        $user = auth()->user();
        
        $modelClass = $validated['reactionable_type'] === 'topic' 
            ? \App\Models\Topic::class 
            : \App\Models\Post::class;
        
        $reactionable = $modelClass::findOrFail($validated['reactionable_id']);
        
        $existingReaction = Reaction::where('user_id', $user->id)
            ->where('reactionable_id', $validated['reactionable_id'])
            ->where('reactionable_type', $modelClass)
            ->first();
        
        if ($existingReaction) {
            if ($existingReaction->type === $validated['type']) {
                $existingReaction->delete();
                return response()->json([
                    'success' => true,
                    'action' => 'removed',
                    'count' => $reactionable->reactions()->count(),
                ]);
            }
            
            $existingReaction->update(['type' => $validated['type']]);
            return response()->json([
                'success' => true,
                'action' => 'updated',
                'count' => $reactionable->reactions()->count(),
            ]);
        }
        
        Reaction::create([
            'user_id' => $user->id,
            'reactionable_id' => $validated['reactionable_id'],
            'reactionable_type' => $modelClass,
            'type' => $validated['type'],
        ]);
        
        return response()->json([
            'success' => true,
            'action' => 'added',
            'count' => $reactionable->reactions()->count(),
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'reactionable_id' => 'required|uuid',
            'reactionable_type' => 'required|string|in:topic,post',
        ]);
        
        $modelClass = $validated['reactionable_type'] === 'topic' 
            ? \App\Models\Topic::class 
            : \App\Models\Post::class;
        
        $reactionable = $modelClass::findOrFail($validated['reactionable_id']);
        
        $reactions = $reactionable->reactions()
            ->with('user:id,name,username,avatar')
            ->get()
            ->groupBy('type')
            ->map(function ($items) {
                return [
                    'count' => $items->count(),
                    'users' => $items->pluck('user')->filter()->unique('id')->values(),
                ];
            });
        
        $userReaction = Reaction::where('user_id', auth()->id())
            ->where('reactionable_id', $validated['reactionable_id'])
            ->where('reactionable_type', $modelClass)
            ->first();
        
        return response()->json([
            'reactions' => $reactions,
            'user_reaction' => $userReaction?->type,
            'total' => $reactionable->reactions()->count(),
        ]);
    }
}
