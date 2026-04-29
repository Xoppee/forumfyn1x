<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMessage;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GroupMessagesController extends Controller
{
    public function messages(Group $group, Request $request): JsonResponse
    {
        $member = GroupMember::where('group_id', $group->id)
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->first();

        if (!$member && $group->creator_id !== auth()->id()) {
            return response()->json(['error' => 'Você não é membro deste grupo.'], 403);
        }

        $messages = GroupMessage::where('group_id', $group->id)
            ->with('user:id,name,username,avatar,is_verified')
            ->orderByDesc('created_at')
            ->paginate(50);

        return response()->json($messages);
    }

    public function send(Request $request, Group $group): JsonResponse
    {
        $member = GroupMember::where('group_id', $group->id)
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->first();

        if (!$member && $group->creator_id !== auth()->id()) {
            return response()->json(['error' => 'Você não é membro deste grupo.'], 403);
        }

        $validated = $request->validate([
            'message' => 'required|string|max:2000',
            'type' => 'nullable|string|in:text,image,file',
        ]);

        $message = GroupMessage::create([
            'group_id' => $group->id,
            'user_id' => auth()->id(),
            'message' => $validated['message'],
            'type' => $validated['type'] ?? 'text',
        ]);

        $message->load('user:id,name,username,avatar,is_verified');

        return response()->json(['message' => $message], 201);
    }

    public function latest(Group $group, Request $request): JsonResponse
    {
        $member = GroupMember::where('group_id', $group->id)
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->first();

        if (!$member && $group->creator_id !== auth()->id()) {
            return response()->json(['error' => 'Você não é membro deste grupo.'], 403);
        }

        $after = $request->get('after', 0);

        $messages = GroupMessage::where('group_id', $group->id)
            ->where('id', '>', $after)
            ->with('user:id,name,username,avatar,is_verified')
            ->orderBy('created_at')
            ->get();

        return response()->json(['messages' => $messages]);
    }

    public function delete(Group $group, GroupMessage $message): JsonResponse
    {
        if ($message->user_id !== auth()->id()) {
            return response()->json(['error' => 'Não autorizado.'], 403);
        }

        if ($message->group_id !== $group->id) {
            return response()->json(['error' => 'Mensagem não pertence a este grupo.'], 400);
        }

        $message->delete();

        return response()->json(['success' => true]);
    }
}