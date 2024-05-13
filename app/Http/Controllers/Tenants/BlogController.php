<?php

namespace App\Http\Controllers\Tenants;

use App\Events\Tenants\BlogCreated;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\Tenants\Blog\StoreBlogRequest;
use App\Http\Requests\Tenants\Blog\UpdateBlogRequest;
use App\Services\Tenants\BlogService as TenantsBlogService;
use App\Models\Tenants\Blog as TenantsBlog;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\User as TenantUser;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class BlogController extends Controller
{
    public function __construct(private TenantsBlogService $blogService) {}

    /**
     * Store a newly created blog in storage.
     *
     * @param StoreBlogRequest $request
     */
    public function store(StoreBlogRequest $request): JsonResponse
    {
        try {
            Gate::authorize('create', TenantsBlog::class);

            $blog = $this->blogService->createBlog(data: $request->validated());
            event(new BlogCreated($blog));
            return jsonResponse(
                message: __('messages.blog.created'),
                data: [new BlogResource($blog)],
                statusCode: 201
            );
        } catch (Exception $e) {
            return jsonResponse(
                message: __('messages.blog.create_failed', ['error' => $e->getMessage()]),
                data: [],
                statusCode: 500
            );
        }
    }

    /**
     * Display a listing of blogs.
     *
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(Request $request): JsonResponse|AnonymousResourceCollection
    {
        try {
            $perPage = $request->get(key: 'per_page', default: 10);
            $blogs = $this->blogService->getAllBlogs(perPage: $perPage);
            return BlogResource::collection(resource: $blogs);
        } catch (Exception $e) {
            return jsonResponse(
                message: __('messages.blog.retrieve_failed', ['error' => $e->getMessage()]),
                data: [],
                statusCode: 500
            );
        }
    }

    /**
     * Display the specified blog.
     *
     * @param TenantsBlog $blog
     * @return JsonResponse
     */
    public function show(TenantsBlog $blog): JsonResponse
    {
        try {

            if ($this->blogService->canViewBlog(blog: $blog)) {
                return jsonResponse(
                    message: __('messages.blog.retrieved'),
                    data: [new BlogResource($blog)],
                    statusCode: 200
                );
            }
            return jsonResponse(
                message: __('messages.blog.unauthorized'),
                data: [],
                statusCode: 403
            );
        } catch (Exception $e) {
            return jsonResponse(
                message: __('messages.blog.retrieve_failed', ['error' => $e->getMessage()]),
                data: [],
                statusCode: 500
            );
        }
    }

    /**
     * Update the specified blog in storage.
     *
     * @param UpdateBlogRequest $request
     * @param TenantsBlog $blog
     * @return JsonResponse
     */
    public function update(UpdateBlogRequest $request, TenantsBlog $blog): JsonResponse
    {
        try {
            $blog = $this->blogService->updateBlog(blog: $blog, data: $request->validated());
            return jsonResponse(
                message: __('messages.blog.updated'),
                data: [new BlogResource($blog)],
                statusCode: 200
            );
        } catch (Exception $e) {
            return jsonResponse(
                message: __('messages.blog.update_failed', ['error' => $e->getMessage()]),
                data: [],
                statusCode: 500
            );
        }
    }

    /**
     * Remove the specified blog from storage.
     *
     * @param TenantsBlog $blog
     * @return JsonResponse
     */
    public function destroy(TenantsBlog $blog): JsonResponse
    {
        try {
            $this->blogService->deleteBlog(blog: $blog);
            return jsonResponse(
                message: __('messages.blog.deleted'),
                data: [],
                statusCode: 200
            );
        } catch (Exception $e) {
            return jsonResponse(
                message: __('messages.blog.delete_failed', ['error' => $e->getMessage()]),
                data: [],
                statusCode: 500
            );
        }
    }

    /**
     * Force delete a blog.
     *
     * @param TenantsBlog $blog
     * @return JsonResponse
     */
    public function forceDelete(TenantsBlog $blog): JsonResponse
    {
        try {
            $this->blogService->forceDeleteBlog(blog: $blog);
            return jsonResponse(
                message: __('messages.blog.permanently_deleted'),
                data: [],
                statusCode: 200
            );
        } catch (Exception $e) {
            return jsonResponse(
                message: __('messages.blog.delete_failed', ['error' => $e->getMessage()]),
                data: [],
                statusCode: 500
            );
        }
    }

    /**
     * Restore a soft-deleted blog.
     *
     * @param int $blogID
     * @return JsonResponse
     */
    public function restore(int $blogID): JsonResponse
    {
        try {
            $blog = TenantsBlog::onlyTrashed()->findOrFail(id: $blogID);
            $this->blogService->restoreBlog(blog: $blog);
            return jsonResponse(
                message: __('messages.blog.restored'),
                data: [],
                statusCode: 200
            );
        } catch (Exception $e) {
            return jsonResponse(
                message: __('messages.blog.restore_failed', ['error' => $e->getMessage()]),
                data: [],
                statusCode: 500
            );
        }
    }
}
