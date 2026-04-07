<?php
// app/Providers/CustomUserProvider.php

namespace App\Providers;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Hash;
use App\Models\CustomUser;

class CustomUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        return CustomUser::find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        return CustomUser::where('id', $identifier)
            ->where('remember_token', $token)
            ->first();
    }

    public function updateRememberToken(UserContract $user, $token)
    {
        $user->setRememberToken($token);
        CustomUser::where('id', $user->getAuthIdentifier())
            ->update(['remember_token' => $token]);
    }

    public function retrieveByCredentials(array $credentials)
    {
        return CustomUser::where('username', $credentials['username'])->first();
    }

    public function validateCredentials(UserContract $user, array $credentials)
    {
        // Support both bcrypt (new) and plain-text (legacy fallback during transition)
        if (Hash::check($credentials['password'], $user->getAuthPassword())) {
            return true;
        }
        // Legacy plain-text fallback — remove once all passwords are hashed
        return $user->getAuthPassword() === $credentials['password'];
    }
}