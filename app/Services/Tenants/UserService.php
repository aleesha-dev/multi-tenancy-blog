<?php

namespace App\Services\Tenants;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserService
{

    /**
     * Get all users with pagination.
     *
     * @param int $perPage 
     * @return LengthAwarePaginator 
     */
    public function getAllUsers(int $perPage = 10): LengthAwarePaginator
    {
        return User::paginate(perPage: $perPage);
    }

    /**
     * Create a new user.
     *
     * @param array $data 
     * @return User 
     */
    public function createUser(array $data): User
    {
        return User::create($data);
    }
    /**
     * Update an existing user.
     *
     * @param User $user 
     * @param array $data 
     * @return User 
     */
    public function updateUser(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }
    /**
     * Delete a user.
     *
     * @param User $user 
     * @return void
     */
    public function deleteUser(User $user): void
    {
        $user->delete();
    }
    /**
     * Find a user by their ID.
     *
     * @param int $id 
     * @return User 
     * @throws ModelNotFoundException 
     */
    public function findUserById(int $id): User
    {
        return User::findOrFail($id);
    }
    /**
     * Check if a user can be deleted.
     *
     * @param User $user 
     * @return bool 
     */
    public function canDeleteUser(User $user): bool
    {
        return Auth::user()->id !== $user->id;
    }

    /**
     * Force delete a user.
     *
     * @param User $user
     * @return void
     */
    public function forceDeleteUser(User $user): void
    {
        $user->forceDelete(); 
    }

    /**
     * Restore a soft-deleted user.
     *
     * @param User $user
     * @return void
     */
    public function restoreUser(User $user): void
    {
        $user->restore();
    }
}
