<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Client\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {    
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $result = $this->userService->login($credentials);
        if ($result) {
            return response()->json($result);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout()
    {
        $result = $this->userService->logout();
        if ($result) {
            return response()->json(['message' => 'Logged out successfully']);
        }

        return response()->json(['message' => 'Logout failed'], 400);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $result = $this->userService->register($data);
        if ($result) {
            return response()->json($result, 201);
        }

        return response()->json(['message' => 'Registration failed'], 400);
    }

    public function verifyEmail(\Illuminate\Http\Request $request, $id, $hash)
    {
        $result = $this->userService->verifyEmail($id, $hash);
        if ($result['verified']) {
            return redirect(config('app.frontend_url') . '/auth/verified-success?verified=1');
        } else {
            return redirect(config('app.frontend_url') . '/auth/verified-success?verified=0&message=' . urlencode($result['message']));
        }
    }

    public function sendVerification(Request $request)
    {
        $user = $request->user();
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 400);
        }
        $user->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification email sent']);
    }
}
