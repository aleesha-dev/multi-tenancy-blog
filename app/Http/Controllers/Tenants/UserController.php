<?php

namespace App\Http\Controllers\Tenants;

use App\Events\Tenants\UserCreated;
use App\Http\Requests\Tenants\StoreUserRequest as TenantsStoreUserRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Services\Tenants\UserService as TenantsUserService;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{
    public function __construct(private TenantsUserService $userService) {}

    /**
     * Store a newly created user in storage.
     *
     * @param TenantsStoreUserRequest $request
     * @return JsonResponse
     */
    public function store(TenantsStoreUserRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->createUser(data: $request->validated());
            event(new UserCreated($user));
            return jsonResponse(message: __('user.create_success'), data: [$user], statusCode: 201);
        } catch (Exception $e) {
            return jsonResponse(message: __('user.delete_failure', ['error' => $e->getMessage()]), data: [], statusCode: 500);
        }
    }

    /**
     * Display a listing of users.
     *
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function index(Request $request): JsonResponse|AnonymousResourceCollection
    {
        try {
            $perPage = $request->get('per_page', default: 10);
            $users = $this->userService->getAllUsers(perPage: $perPage);
            return UserResource::collection(resource: $users);
        } catch (Exception $e) {
            return jsonResponse(message: __('user.retrieve_failure', ['error' => $e->getMessage()]), data: [], statusCode: 500);
        }
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        try {
            return jsonResponse(message: __('user.retrieve_success'), data: [$user], statusCode: 200);
        } catch (Exception $e) {
            return jsonResponse(message: __('user.delete_failure', ['error' => $e->getMessage()]), data: [], statusCode: 500);
        }
    }

    /**
     * Update the specified user in storage.
     *
     * @param TenantsStoreUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(TenantsStoreUserRequest $request, User $user): JsonResponse
    {
        try {
            $user = $this->userService->updateUser(user: $user, data: $request->validated());
            return jsonResponse(message: __('user.update_success'), data: [$user], statusCode: 200);
        } catch (Exception $e) {
            return jsonResponse(message: __('user.delete_failure', ['error' => $e->getMessage()]), data: [], statusCode: 500);
        }
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            if (!$this->userService->canDeleteUser($user)) {
                return jsonResponse(message: __('user.self_delete_error'), data: [], statusCode: 403);
            }
            $this->userService->deleteUser($user);
            return jsonResponse(message: __('user.delete_success'), data: [], statusCode: 200);
        } catch (Exception $e) {
            return jsonResponse(message: __('user.delete_failure', ['error' => $e->getMessage()]), data: [], statusCode: 500);
        }
    }

    /**
     * Force delete a user.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function forceDelete(User $user): JsonResponse
    {
        try {
            $this->userService->forceDeleteUser(user: $user);
            return jsonResponse(message: __('user.force_delete_success'), data: [], statusCode: 200);
        } catch (Exception $e) {
            return jsonResponse(message: __('user.delete_failure', ['error' => $e->getMessage()]), data: [], statusCode: 500);
        }
    }

    /**
     * Restore a soft-deleted user.
     *
     * @param int $userID
     * @return JsonResponse
     */
    public function restore(int $userID): JsonResponse
    {
        try {
            $user = User::onlyTrashed()->findOrFail(id: $userID);
            $this->userService->restoreUser(user: $user);
            return jsonResponse(message: __('user.restore_success'), data: [], statusCode: 200);
        } catch (Exception $e) {
            return jsonResponse(message: __('user.restore_failure', ['error' => $e->getMessage()]), data: [], statusCode: 500);
        }
    }
}
