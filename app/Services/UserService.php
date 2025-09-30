<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function login($credentials)
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token', ['*'], now()->addMonth())->plainTextToken;

            return [
                'access_token' => $token,
                'message' => 'Login successful'
            ];
        }

        return [];
    }

    public function logout()
    {
        $user = Auth::user();
        $accessToken = $user->currentAccessToken();
        if ($user) {
            $user->tokens()->where('id', $accessToken->id)->delete();
            return true;
        }
        return false;
    }

    public function register($data)
    {
        $user = $this->userRepository->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        if ($user) {
            $token = $user->createToken('auth_token', ['*'], now()->addMonth())->plainTextToken;

            return [
                'access_token' => $token,
                'message' => 'Registration successful'
            ];
        }

        return [];
    }
}