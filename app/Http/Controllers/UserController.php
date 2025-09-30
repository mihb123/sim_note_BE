<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

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
}
