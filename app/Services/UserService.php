<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Log;

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
                'token' => $token,
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
            event(new Registered($user));
            $token = $user->createToken('auth_token', ['*'], now()->addMonth())->plainTextToken;
            return [
                'token' => $token,
                'message' => 'Registration successful. Please check your email to verify your account.'
            ];
        }

        return [];
    }

    public function verifyEmail($id, $hash)
    {
        $user = \App\Models\User::findOrFail($id);
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            Log::info('Verification failed: Invalid hash');
            return ['verified' => false, 'message' => 'Invalid hash'];
        }
        if ($user->hasVerifiedEmail()) {
            Log::info('Email already verified');
            return ['verified' => true, 'message' => 'Email already verified'];
        }
        $user->markEmailAsVerified();
        event(new Verified($user));
        return ['verified' => true, 'message' => 'Email verified successfully'];
    }
}