<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MobileSessionLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CollectorAuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'device_id' => ['required', 'string', 'max:120'],
            'device_name' => ['nullable', 'string', 'max:120'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password) || ! $user->hasRole('Collector')) {
            throw ValidationException::withMessages(['email' => 'Invalid collector credentials.']);
        }

        $token = $user->createToken('collector-'.$credentials['device_id'], ['collector'], now()->addHours(12))->plainTextToken;

        MobileSessionLog::create([
            'collector_id' => $user->id,
            'device_id' => $credentials['device_id'],
            'device_name' => $credentials['device_name'] ?? null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'logged_in_at' => now(),
            'expires_at' => now()->addHours(12),
        ]);

        return response()->json(['token' => $token, 'collector' => $user]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'Logged out.']);
    }
}
