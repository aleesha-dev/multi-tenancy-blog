<?php

namespace App\Policies\Tenants;

use App\Models\Tenants\Blog;
use App\Enums\RolePermission;
use App\Models\User as TenantUser;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BlogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create blogs.
     *
     * @param TenantUser $user
     * @return Response
     */
    public function create(TenantUser $user): Response
    {
        if ($user->hasPermission(RolePermission::CREATE_BLOG)) {
            return Response::allow();
        }

        return Response::deny(__('messages.blog_created_permission'));
    }

    /**
     * Determine whether the user can view all blogs.
     *
     * @param TenantUser $user
     * @return bool
     */
    public function viewAll(TenantUser $user): bool
    {
        return $user->hasPermission(RolePermission::VIEW_ALL_BLOGS);
    }

    /**
     * Determine whether the user can view their own blogs.
     *
     * @param TenantUser $user
     * @return bool
     */
    public function viewOwn(TenantUser $user): bool
    {
        return $user->hasPermission(RolePermission::VIEW_OWN_BLOG);
    }

    /**
     * Determine whether the user can update any blog.
     *
     * @param TenantUser $user
     * @return bool
     */
    public function updateAny(TenantUser $user): bool
    {
        return $user->hasPermission(RolePermission::EDIT_ANY_BLOG);
    }

    /**
     * Determine whether the user can update their own blogs.
     *
     * @param TenantUser $user
     * @return bool
     */
    public function updateOwn(TenantUser $user): bool
    {
        return $user->hasPermission(RolePermission::EDIT_OWN_BLOG);
    }

    /**
     * Determine whether the user can delete any blog.
     *
     * @param TenantUser $user
     * @return bool
     */
    public function deleteAny(TenantUser $user): bool
    {
        return $user->hasPermission(RolePermission::DELETE_ANY_BLOG);
    }

    /**
     * Determine whether the user can delete their own blogs.
     *
     * @param TenantUser $user
     * @return bool
     */
    public function deleteOwn(TenantUser $user): bool
    {
        return $user->hasPermission(RolePermission::DELETE_OWN_BLOG);
    }

    /**
     * Determine whether the user can force delete any blog.
     *
     * @param TenantUser $user
     * @return bool
     */
    public function forceDeleteAny(TenantUser $user): bool
    {
        return $user->hasPermission(RolePermission::FORCE_DELETE_ANY_BLOG);
    }

    /**
     * Determine whether the user can force delete their own blogs.
     *
     * @param TenantUser $user
     * @return bool
     */
    public function forceDeleteOwn(TenantUser $user): bool
    {
        return $user->hasPermission(RolePermission::FORCE_DELETE_OWN_BLOG);
    }

    /**
     * Determine whether the user can restore any blog.
     *
     * @param TenantUser $user
     * @return bool
     */
    public function restoreAny(TenantUser $user): bool
    {
        return $user->hasPermission(RolePermission::RESTORE_ANY_BLOG);
    }

    /**
     * Determine whether the user can restore their own blogs.
     *
     * @param TenantUser $user
     * @return bool
     */
    public function restoreOwn(TenantUser $user): bool
    {
        return $user->hasPermission(RolePermission::RESTORE_OWN_BLOG);
    }

    /**
     * Determine whether the user can view any blog's details.
     *
     * @param TenantUser $user
     * @return bool
     */
    public function detailAny(TenantUser $user): bool
    {
        return $user->hasPermission(RolePermission::DETAIL_ANY_BLOG);
    }

    /**
     * Determine whether the user can view the details of their own blogs.
     *
     * @param TenantUser $user
     * @return bool
     */
    public function detailOwn(TenantUser $user): bool
    {
        return $user->hasPermission(RolePermission::DETAIL_OWN_BLOG);
    }
}
