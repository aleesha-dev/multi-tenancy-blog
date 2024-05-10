<?php

namespace App\Services\Tenants;

use App\Http\Resources\RoleResource;
use App\Models\Tenants\Role;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleService
{

    /**
     * Get all roles with pagination.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllRoles(int $perPage = 10): LengthAwarePaginator
    {
        return Role::paginate($perPage);
    }

    /**
     * Create a new role.
     *
     * @param array $data
     * @return Role
     */
    public function createRole(array $data): Role
    {
        if (isset($data['permissions'])) {
            $data['permissions'] = json_encode($data['permissions']);
        }

        return Role::create($data);
    }

    /**
     * Update an existing role.
     *
     * @param Role $role
     * @param array $data
     * @return Role
     */
    public function updateRole(Role $role, array $data): Role
    {
        $role->update($data);
        return $role;
    }

    /**
     * Delete a role.
     *
     * @param Role $role
     * @return void
     */
    public function deleteRole(Role $role): void
    {
        $role->delete();
    }

    /**
     * Find a role by its ID.
     *
     * @param int $id
     * @return Role
     * @throws ModelNotFoundException
     */
    public function findRoleById(int $id): Role
    {
        return Role::findOrFail($id);
    }
}
