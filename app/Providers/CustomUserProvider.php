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
            'password' => 'Nusantara@1',
            'operasional' => false,
            'aset' => false,
            'finansial' => false,
            'hr'=>false,
            'sales'=>false,
            'legal'=>false,
            'progress'=>false,
            'pengadaan'=>false,
            'carbon'=>false
        ],
        [
            'id' => 2,
            'username' => 'superadmin',
            'password' => 'Nusantara1@!',
            'operasional' => true,
            'aset' => true,
            'finansial' => true,
            'hr'=>true,
            'sales'=>true,
            'legal'=>true,
            'progress'=>true,
            'pengadaan'=>true,
            'carbon'=>true
        ],
        [
            'id' => 3,
            'username' => 'mrc',
            'password' => 'Nusantara@1',
            'operasional' => false,
            'aset' => false,
            'finansial' => false,
            'hr'=>false,
            'sales'=>false,
            'legal'=>false,
            'progress'=>false,
            'pengadaan'=>false,
            'carbon'=>false
        ],
        [
            'id' => 4,
            'username' => 'dksk',
            'password' => 'dksk@4121',
            'operasional' => true,
            'aset' => true,
            'finansial' => false,
            'hr'=>false,
            'sales'=>true,
            'legal'=>false,
            'progress'=>true,
            'pengadaan'=>false,
            'carbon'=>false
        ],
        [
            'id' => 5,
            'username' => 'dkat',
            'password' => 'dkat@5234',
            'operasional' => true,
            'aset' => true,
            'finansial' => true,
            'hr'=>false,
            'sales'=>false,
            'legal'=>false,
            'progress'=>true,
            'pengadaan'=>false,
            'carbon'=>false
        ],
        [
            'id' => 6,
            'username' => 'dpsb',
            'password' => 'dpsb@6452',
            'operasional' => false,
            'aset' => false,
            'finansial' => true,
            'hr'=>true,
            'sales'=>false,
            'legal'=>false,
            'progress'=>true,
            'pengadaan'=>false,
            'carbon'=>false
        ],
        [
            'id' => 7,
            'username' => 'dmas1',
            'password' => 'dmas1@7865',
            'operasional' => false,
            'aset' => true,
            'finansial' => true,
            'hr'=>false,
            'sales'=>false,
            'legal'=>false,
            'progress'=>true,
            'pengadaan'=>false,
            'carbon'=>false
        ],
        [
            'id' => 8,
            'username' => 'dmas2',
            'password' => 'dmas2@8965',
            'operasional' => false,
            'aset' => true,
            'finansial' => true,
            'hr'=>false,
            'sales'=>false,
            'legal'=>false,
            'progress'=>true,
            'pengadaan'=>false,
            'carbon'=>false
        ],
        [
            'id' => 9,
            'username' => 'dpak',
            'password' => 'dpak@9012',
            'operasional' => false,
            'aset' => false,
            'finansial' => true,
            'hr'=>false,
            'sales'=>false,
            'legal'=>false,
            'progress'=>true,
            'pengadaan'=>false,
            'carbon'=>false
        ],
        [
            'id' => 10,
            'username' => 'dpaj',
            'password' => 'dpaj@10112',
            'operasional' => false,
            'aset' => false,
            'finansial' => true,
            'hr'=>false,
            'sales'=>false,
            'legal'=>false,
            'progress'=>true,
            'pengadaan'=>false,
            'carbon'=>false
        ],
        [
            'id' => 11,
            'username' => 'dmrs',
            'password' => 'dmrs@11546',
            'operasional' => false,
            'aset' => false,
            'finansial' => true,
            'hr'=>false,
            'sales'=>false,
            'legal'=>false,
            'progress'=>true,
            'pengadaan'=>false,
            'carbon'=>true
        ],
        [
            'id' => 12,
            'username' => 'dmps',
            'password' => 'dmps@12657',
            'operasional' => false,
            'aset' => false,
            'finansial' => true,
            'hr'=>false,
            'sales'=>false,
            'legal'=>false,
            'progress'=>true,
            'pengadaan'=>false,
            'carbon'=>true
        ],
        [
            'id' => 13,
            'username' => 'dhkm',
            'password' => 'dhkm@13567',
            'operasional' => false,
            'aset' => true,
            'finansial' => true,
            'hr'=>false,
            'sales'=>false,
            'legal'=>true,
            'progress'=>true,
            'pengadaan'=>false,
            'carbon'=>true
        ],
        [
            'id' => 14,
            'username' => 'dpti',
            'password' => 'dpti@14234',
            'operasional' => false,
            'aset' => false,
            'finansial' => true,
            'hr'=>false,
            'sales'=>false,
            'legal'=>false,
            'progress'=>true,
            'pengadaan'=>true,
            'carbon'=>false
        ],
        [
            'id' => 15,
            'username' => 'dpsk',
            'password' => 'dpsk@15123',
            'operasional' => false,
            'aset' => false,
            'finansial' => true,
            'hr'=>false,
            'sales'=>false,
            'legal'=>false,
            'progress'=>true,
            'pengadaan'=>false,
            'carbon'=>false
        ],
        [
            'id' => 16,
            'username' => 'pmo',
            'password' => 'pmo@16765',
            'operasional' => true,
            'aset' => true,
            'finansial' => true,
            'hr'=>true,
            'sales'=>true,
            'legal'=>true,
            'progress'=>true,
            'pengadaan'=>true,
            'carbon'=>true
        ],
        [
            'id' => 17,
            'username' => 'ti',
            'password' => 'Nusantara@1',
            'operasional' => true,
            'aset' => true,
            'finansial' => true,
            'hr'=>true,
            'sales'=>true,
            'legal'=>true,
            'progress'=>true,
            'pengadaan'=>true,
            'carbon'=>true
        ],
        [
            'id' => 18,
            'username' => 'holding',
            'password' => 'Nusantara@1',
            'operasional' => false,
            'aset' => false,
            'finansial' => false,
            'hr'=>true,
            'sales'=>false,
            'legal'=>false,
            'progress'=>true,
            'pengadaan'=>false,
            'carbon'=>true
        ],
        [
            'id' => 19,
            'username' => 'pmn',
            'password' => 'pmn@19465',
            'operasional' => false,
            'aset' => false,
            'finansial' => true,
            'hr'=>false,
            'sales'=>false,
            'legal'=>false,
            'progress'=>true,
            'pengadaan'=>false,
            'carbon'=>false
        ],
        [
            'id' => 20,
            'username' => 'dspi',
            'password' => 'dspi@20768',
            'operasional' => true,
            'aset' => true,
            'finansial' => true,
            'hr'=>true,
            'sales'=>true,
            'legal'=>true,
            'progress'=>true,
            'pengadaan'=>true,
            'carbon'=>true
        ],
        [
            'id' => 21,
            'username' => 'dktb',
            'password' => 'dktb@21543',
            'operasional' => false,
            'aset' => false,
            'finansial' => true,
            'hr'=>true,
            'sales'=>false,
            'legal'=>false,
            'progress'=>true,
            'pengadaan'=>false,
            'carbon'=>true
        ],
        [
            'id' => 22,
            'username' => 'dspr',
            'password' => 'dspr@22098',
            'operasional' => false,
            'aset' => false,
            'finansial' => true,
            'hr'=>false,
            'sales'=>false,
            'legal'=>false,
            'progress'=>false,
            'pengadaan'=>false,
            'carbon'=>false
        ],
        [
            'id' => 23,
            'username' => 'dipb',
            'password' => 'dipb@23768',
            'operasional' => false,
            'aset' => false,
            'finansial' => true,
            'hr'=>false,
            'sales'=>false,
            'legal'=>false,
            'progress'=>false,
            'pengadaan'=>false,
            'carbon'=>false
        ],
        [
            'id' => 24,
            'username' => 'dhkl',
            'password' => 'dhkl@24765',
            'operasional' => false,
            'aset' => false,
            'finansial' => true,
            'hr'=>false,
            'sales'=>false,
            'legal'=>false,
            'progress'=>false,
            'pengadaan'=>false,
            'carbon'=>false
        ],
        [
            'id' => 25,
            'username' => 'dosg',
            'password' => 'dosg@25765',
            'operasional' => false,
            'aset' => false,
            'finansial' => true,
            'hr'=>true,
            'sales'=>false,
            'legal'=>false,
            'progress'=>false,
            'pengadaan'=>false,
            'carbon'=>false
        ],
        [
            'id' => 26,
            'username' => 'direksi',
            'password' => 'direksiNusantara@1',
            'operasional' => true,
            'aset' => true,
            'finansial' => true,
            'hr'=>true,
            'sales'=>true,
            'legal'=>true,
            'progress'=>true,
            'pengadaan'=>true,
            'carbon'=>true
        ],
        [
            'id' => 27,
            'username' => 'dekom',
            'password' => 'Nusantara@1',
            'operasional' => false,
            'aset' => false,
            'finansial' => false,
            'hr'=>false,
            'sales'=>false,
            'legal'=>false,
            'progress'=>false,
            'pengadaan'=>false,
            'carbon'=>false
        ],
        [
            'id' => 28,
            'username' => 'pemasaran_holding',
            'password' => 'pemasaranhold@1',
            'operasional' => false,
            'aset' => false,
            'finansial' => false,
            'hr'=>false,
            'sales'=>true,
            'legal'=>false,
            'progress'=>false,
            'pengadaan'=>false,
            'carbon'=>false
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