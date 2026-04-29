<?php

namespace App\Http\Controllers;

use App\Models\UserVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserVerificationController extends Controller
{
    public function status(): JsonResponse
    {
        $user = auth()->user();
        
        $verification = UserVerification::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->first();

        if (!$verification) {
            $verification = UserVerification::create([
                'user_id' => $user->id,
                'status' => 'pending',
            ]);
            $verification->calculateStats();
        }

        if ($verification->status === 'approved') {
            return response()->json([
                'status' => 'verified',
                'is_verified' => $user->is_verified,
            ]);
        }

        return response()->json([
            'status' => $verification->status,
            'progress' => $verification->progress(),
            'is_verified' => $user->is_verified,
        ]);
    }

    public function request(Request $request): JsonResponse
    {
        $user = auth()->user();

        $existingRequest = UserVerification::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return response()->json([
                'error' => 'Você já tem uma solicitação pendente.',
            ], 400);
        }

        $verification = UserVerification::create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);
        $verification->calculateStats();

        if (!$verification->meetsRequirements()) {
            return response()->json([
                'error' => 'Você não atende os requisitos mínimos.',
                'progress' => $verification->progress(),
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Solicitação enviada! Aguarde aprovação.',
            'verification' => $verification,
        ]);
    }

public function progress(): JsonResponse
    {
        $user = auth()->user();

        $verification = UserVerification::firstOrCreate(
            ['user_id' => $user->id],
            ['user_id' => $user->id, 'status' => 'pending']
        );
        $verification->calculateStats();

        return response()->json([
            'progress' => $verification->progress(),
            'requirements' => UserVerification::requirementsMet(),
        ]);
    }

    public function webIndex()
    {
        $user = auth()->user();
        
        $verification = UserVerification::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->first();

        if (!$verification) {
            $verification = UserVerification::create([
                'user_id' => $user->id,
                'status' => 'pending',
            ]);
            $verification->calculateStats();
        }

        return view('verification.index', [
            'verification' => $verification,
            'progress' => $verification->progress(),
            'requirements' => UserVerification::requirementsMet(),
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $query = UserVerification::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $verifications = $query->orderByDesc('created_at')
            ->with('user')
            ->paginate(20);

        return response()->json($verifications);
    }

    public function approve(UserVerification $verification): JsonResponse
    {
        $verification->update([
            'status' => 'approved',
            'rejection_reason' => null,
        ]);

        $verification->user->update(['is_verified' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Usuário verificado com sucesso!',
        ]);
    }

    public function reject(Request $request, UserVerification $verification): JsonResponse
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $verification->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Solicitação rejeitada.',
        ]);
    }
}