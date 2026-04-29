<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupRole;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GroupController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Group::query();

        if ($request->has('private')) {
            $query->where('is_private', $request->boolean('private'));
        }

        if ($request->has('verified')) {
            $query->where('is_verified', $request->boolean('verified'));
        }

        $groups = $query->orderBy('name')->paginate(20);

        return response()->json($groups);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_private' => 'boolean',
        ]);

        $group = Group::create([
            ...$validated,
            'creator_id' => auth()->id(),
        ]);

        $defaultRole = GroupRole::create([
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
        ]);

        GroupMember::create([
            'group_id' => $group->id,
            'user_id' => auth()->id(),
            'group_role_id' => $defaultRole->id,
            'status' => 'approved',
        ]);

        return response()->json(['group' => $group, 'role' => $defaultRole], 201);
    }

    public function show(Group $group): JsonResponse
    {
        $group->load(['roles', 'creator']);

        $members = GroupMember::where('group_id', $group->id)
            ->where('status', 'approved')
            ->with(['user', 'groupRole'])
            ->get();

        $pages = \App\Models\Pages::orderBy('index', 'ASC')->get();

        return response()->json([
            'group' => $group,
            'members' => $members,
            'pages' => $pages
        ]);
    }

    public function update(Request $request, Group $group): JsonResponse
    {
        $member = GroupMember::where('group_id', $group->id)
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->first();

        $canEdit = $member?->groupRole?->can_edit 
            ?? $group->creator_id === auth()->id();

        if (!$canEdit) {
            return response()->json(['error' => 'Não autorizado.'], 403);
        }

        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'is_private' => 'boolean',
        ]);

        $group->update($validated);

        return response()->json(['group' => $group]);
    }

    public function destroy(Group $group): JsonResponse
    {
        if ($group->creator_id !== auth()->id()) {
            return response()->json(['error' => 'Apenas o criador pode excluir o grupo.'], 403);
        }

        $group->delete();

        return response()->json(['success' => true, 'message' => 'Grupo excluído.']);
    }

    public function join(Request $request, Group $group): JsonResponse
    {
        $user = auth()->user();

        if ($group->isMember($user)) {
            return response()->json(['error' => 'Você já é membro deste grupo.'], 400);
        }

        if ($group->isBannedMember($user)) {
            return response()->json(['error' => 'Você foi banido deste grupo.'], 403);
        }

        $status = $group->is_private ? 'pending' : 'approved';

        GroupMember::create([
            'group_id' => $group->id,
            'user_id' => $user->id,
            'status' => $status,
        ]);

        $group->checkAndUpdateVerified();

        return response()->json([
            'success' => true,
            'message' => $status === 'pending' 
                ? 'Solicitação enviada. Aguarde aprovação.' 
                : 'Você entrou no grupo.'
        ]);
    }

    public function leave(Group $group): JsonResponse
    {
        $member = GroupMember::where('group_id', $group->id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$member) {
            return response()->json(['error' => 'Você não é membro deste grupo.'], 400);
        }

        if ($group->creator_id === auth()->id()) {
            return response()->json(['error' => 'O criador não pode sair do grupo. Transfira primeiro.'], 400);
        }

        $member->delete();
        
        $group->checkAndUpdateVerified();

        return response()->json(['success' => true, 'message' => 'Você saiu do grupo.']);
    }

    public function members(Group $group): JsonResponse
    {
        $members = GroupMember::where('group_id', $group->id)
            ->where('status', 'approved')
            ->with(['user', 'groupRole'])
            ->get();

        return response()->json(['members' => $members]);
    }

    public function pendingMembers(Group $group): JsonResponse
    {
        $member = GroupMember::where('group_id', $group->id)
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->first();

        $canManage = $member?->groupRole?->can_manage 
            ?? $group->creator_id === auth()->id();

        if (!$canManage) {
            return response()->json(['error' => 'Não autorizado.'], 403);
        }

        $pending = GroupMember::where('group_id', $group->id)
            ->where('status', 'pending')
            ->with(['user'])
            ->get();

        return response()->json(['pending' => $pending]);
    }

    public function approveMember(Group $group, User $user): JsonResponse
    {
        $member = GroupMember::where('group_id', $group->id)
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->first();

        $canManage = $member?->groupRole?->can_manage 
            ?? $group->creator_id === auth()->id();

        if (!$canManage) {
            return response()->json(['error' => 'Não autorizado.'], 403);
        }

        $pendingMember = GroupMember::where('group_id', $group->id)
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if (!$pendingMember) {
            return response()->json(['error' => 'Usuário não encontrada ou já aprovado.'], 404);
        }

        $pendingMember->update(['status' => 'approved']);
        $group->checkAndUpdateVerified();

        return response()->json(['success' => true, 'message' => 'Membro aprovado.']);
    }

    public function banMember(Group $group, User $user): JsonResponse
    {
        $member = GroupMember::where('group_id', $group->id)
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->first();

        $canKick = $member?->groupRole?->can_kick 
            ?? $group->creator_id === auth()->id();

        if (!$canKick) {
            return response()->json(['error' => 'Não autorizado.'], 403);
        }

        if ($group->creator_id === $user->id) {
            return response()->json(['error' => 'Não pode banir o criador.'], 400);
        }

        $groupMember = GroupMember::where('group_id', $group->id)
            ->where('user_id', $user->id)
            ->first();

        if ($groupMember) {
            $groupMember->update(['status' => 'banned']);
        } else {
            GroupMember::create([
                'group_id' => $group->id,
                'user_id' => $user->id,
                'status' => 'banned',
            ]);
        }

        $group->checkAndUpdateVerified();

        return response()->json(['success' => true, 'message' => 'Membro banido.']);
    }

    public function createRole(Request $request, Group $group): JsonResponse
    {
        $member = GroupMember::where('group_id', $group->id)
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->first();

        $canManage = $member?->groupRole?->can_manage 
            ?? $group->creator_id === auth()->id();

        if (!$canManage) {
            return response()->json(['error' => 'Não autorizado.'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:20',
            'level' => 'nullable|integer|min:0|max:100',
            'can_manage' => 'boolean',
            'can_kick' => 'boolean',
            'can_edit' => 'boolean',
            'can_delete' => 'boolean',
            'can_moderate' => 'boolean',
        ]);

        $role = GroupRole::create([
            ...$validated,
            'group_id' => $group->id,
            'slug' => \Str::slug($validated['name']),
        ]);

        return response()->json(['role' => $role], 201);
    }

    public function updateRole(Request $request, Group $group, GroupRole $role): JsonResponse
    {
        if ($role->group_id !== $group->id) {
            return response()->json(['error' => 'Cargo não pertence ao grupo.'], 400);
        }

        $member = GroupMember::where('group_id', $group->id)
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->first();

        $canManage = $member?->groupRole?->can_manage 
            ?? $group->creator_id === auth()->id();

        if (!$canManage) {
            return response()->json(['error' => 'Não autorizado.'], 403);
        }

        $validated = $request->validate([
            'name' => 'string|max:255',
            'color' => 'nullable|string|max:20',
            'level' => 'nullable|integer|min:0|max:100',
            'can_manage' => 'boolean',
            'can_kick' => 'boolean',
            'can_edit' => 'boolean',
            'can_delete' => 'boolean',
            'can_moderate' => 'boolean',
        ]);

        $role->update($validated);

        return response()->json(['role' => $role]);
    }

    public function deleteRole(Group $group, GroupRole $role): JsonResponse
    {
        if ($role->group_id !== $group->id) {
            return response()->json(['error' => 'Cargo não pertence ao grupo.'], 400);
        }

        $member = GroupMember::where('group_id', $group->id)
            ->where('user_id', auth()->id())
            ->where('status', 'approved')
            ->first();

        $canManage = $member?->groupRole?->can_manage 
            ?? $group->creator_id === auth()->id();

        if (!$canManage) {
            return response()->json(['error' => 'Não autorizado.'], 403);
        }

        $role->delete();

        return response()->json(['success' => true, 'message' => 'Cargo excluído.']);
    }

    // Web Views
    public function webIndex()
    {
        $userGroups = [];
        if (auth()->check()) {
            $userGroups = GroupMember::where('user_id', auth()->id())
                ->where('status', 'approved')
                ->with('group')
                ->get()
                ->pluck('group');
        }

        return view('groups.index', compact('userGroups'));
    }

    public function webDiscover()
    {
        $groups = Group::where('is_private', false)
            ->orderBy('is_verified', 'DESC')
            ->orderBy('name')
            ->paginate(20);
        return view('groups.discover', compact('groups'));
    }

    public function webCreate()
    {
        return view('groups.create');
    }

    public function webShow(string $slug)
    {
        $group = Group::where('slug', $slug)->firstOrFail();
        
        $group->load(['roles', 'creator', 'topics.posts', 'topics.user']);
        $members = GroupMember::where('group_id', $group->id)
            ->where('status', 'approved')
            ->with(['user', 'groupRole'])
            ->get();
        return view('groups.show', compact('group', 'members'));
    }
}