<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class TenantPolicy
{
    /**
     * Determine if the user can create a tenant.
     *
     * @param User $user
     * @return \Illuminate\Auth\Access\Response
     */
    public function create(User $user): Response
    {
        if (!$user->tenant_id && $user->role === 'admin') {
            return Response::allow();
        }

        return Response::deny(__('messages.add_tenants_permission'));
    }
}
