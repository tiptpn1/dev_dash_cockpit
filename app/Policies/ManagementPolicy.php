<?php

namespace App\Policies;

use App\Models\CustomUser;

class ManagementPolicy
{
    /**
     * Check if user is superadmin
     */
    public function isSuperAdmin(CustomUser $user): bool
    {
        return $user->username === 'superadmin' || $user->role === 'superadmin';
    }
}
