<?php

namespace App\Services\Tenants;

use App\Enums\RolePermission;
use App\Models\Tenants\Blog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\User as TenantUser;
use Illuminate\Support\Facades\Gate;

class BlogService
{
    /**
     * Get all blogs for the authenticated user.
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllBlogs(int $perPage = 10): LengthAwarePaginator
    {

        if (Gate::allows('view-all', Blog::class)) {
            return Blog::paginate($perPage);
        }

        if (Gate::allows('view-own', Blog::class)) {
            return Blog::withUser()->paginate($perPage);
        }

        throw new AuthorizationException(__('messages.blog.blog_view_unauthorized'), 403);
    }

    /**
     * Create a new blog for the authenticated user.
     *
     * @param array $data
     * @return Blog
     */
    public function createBlog(array $data): Blog
    {
        $data['user_id'] = Auth::id();
        $blog = Blog::create($data);
        return $blog;
    }

    /**
     * Update an existing blog.
     *
     * @param Blog $blog
     * @param array $data
     * @return Blog
     */
    public function updateBlog(Blog $blog, array $data): Blog
    {
        if (
            Gate::allows('update-any', Blog::class) ||
            (Gate::allows('update-own', Blog::class)) && $blog->user_id === Auth::id()
        ) {
            $blog->update($data);
            return $blog;
        }

        throw new AuthorizationException(__('messages.blog.blog_edit_unauthorized'), 403);
    }

    /**
     * Delete a blog by its ID.
     * @param Blog $blog
     * @return void
     */
    public function deleteBlog(Blog $blog): void
    {
        if (
            Gate::allows('delete-any', Blog::class) ||
            Gate::allows('delete-own', Blog::class) && $blog->user_id === Auth::id()
        ) {
            $blog->delete();
            return;
        }

        throw new AuthorizationException(__('messages.blog.blog_delete_unauthorized'), 403);
    }

    /**
     * Force delete a blog.
     *
     * @param Blog $blog
     * @return void
     */
    public function forceDeleteBlog(Blog $blog): void
    {
        if (
            Gate::allows('force-delete-any', Blog::class) ||
            Gate::allows('force-delete-own', Blog::class) && $blog->user_id === Auth::id()
        ) {
            $blog->forceDelete();
            return;
        }

        throw new AuthorizationException(__('messages.blog.blog_force_delete_unauthorized'), 403);
    }

    /**
     * Restore a soft-deleted blog.
     *
     * @param Blog $blog
     * @return void
     */
    public function restoreBlog(Blog $blog): void
    {
        if (
            Gate::allows('restore-any', Blog::class) ||
            Gate::allows('restore-own', Blog::class) && $blog->user_id === Auth::id()
        ) {
            $blog->restore();
            return;
        }

        throw new AuthorizationException(__('messages.blog.blog_restore_unauthorized'), 403);
    }

    /**
     * Check if the authenticated user has permission to view the specified blog.
     *
     * @param Blog $blog
     * @return bool
     */
    public function canViewBlog(Blog $blog): bool
    {
        return Gate::allows('detail-any', Blog::class) ||
            Gate::allows('detail-own', Blog::class) && $blog->user_id === Auth::id();
    }
}
