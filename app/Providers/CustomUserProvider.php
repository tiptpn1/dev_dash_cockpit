<?php
// app/Providers/CustomUserProvider.php

namespace App\Providers;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use App\Models\CustomUser;

class CustomUserProvider implements UserProvider
{
    protected $users = [
        [
            'id' => 1,
            'username' => 'admin',
            'password' => 'password',
        ],
        [
            'id' => 2,
            'username' => 'superadmin',
            'password' => 'Nusantara@1',
        ],
    ];

    public function retrieveById($identifier)
    {
        foreach ($this->users as $user) {
            if ($user['id'] == $identifier) {
                return new CustomUser($user);
            }
        }

        return null;
    }

    public function retrieveByToken($identifier, $token)
    {
        // Not implemented
    }

    public function updateRememberToken(UserContract $user, $token)
    {
        // Not implemented
    }

    public function retrieveByCredentials(array $credentials)
    {
        foreach ($this->users as $user) {
            if ($user['username'] == $credentials['username']) {
                return new CustomUser($user);
            }
        }

        return null;
    }

    public function validateCredentials(UserContract $user, array $credentials)
    {
        return $user->password === $credentials['password'];
    }
}