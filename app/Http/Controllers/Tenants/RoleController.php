<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\Tenants\StoreRoleRequest as TenantsStoreRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Tenants\Role as TenantsRole;
use App\Services\Tenants\RoleService as TenantsRoleService;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoleController extends Controller
{
    public function __construct(private TenantsRoleService $roleService) {}

    /**
     * Store a newly created role in storage.
     *
     * @param TenantsStoreRoleRequest $request
     * @return JsonResponse
     */
    public function store(TenantsStoreRoleRequest $request): JsonResponse
    {
        try {
            $role = $this->roleService->createRole(data: $request->validated());
            return jsonResponse(message: __('role.create_success'), data: [$role], statusCode: 201);
        } catch (Exception $e) {
            return jsonResponse(message: __('role.delete_failure', ['error' => $e->getMessage()]), data: [], statusCode: 500);
        }
    }

    /**
     * Display a listing of roles.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse|AnonymousResourceCollection
    {
        try {
            $perPage = $request->get('per_page', default: 10);
            $roles = $this->roleService->getAllRoles(perPage: $perPage);
            return RoleResource::collection(resource: $roles);
        } catch (Exception $e) {
            return jsonResponse(message: __('role.retrieve_failure', ['error' => $e->getMessage()]), data: [], statusCode: 500);
        }
    }

    /**
     * Display the specified role.
     *
     * @param TenantsRole $role
     * @return JsonResponse
     */
    public function show(TenantsRole $role): JsonResponse
    {
        try {
            return jsonResponse(message: __('role.retrieve_success'), data: [$role], statusCode: 200);
        } catch (Exception $e) {
            return jsonResponse(message: __('role.delete_failure', ['error' => $e->getMessage()]), data: [], statusCode: 500);
        }
    }

    /**
     * Update the specified role in storage.
     *
     * @param TenantsStoreRoleRequest $request
     * @param TenantsRole $role
     * @return JsonResponse
     */
    public function update(TenantsStoreRoleRequest $request, TenantsRole $role): JsonResponse
    {
        try {
            $role = $this->roleService->updateRole(role: $role, data: $request->validated());
            return jsonResponse(message: __('role.update_success'), data: [$role], statusCode: 200);
        } catch (Exception $e) {
            return jsonResponse(message: __('role.delete_failure', ['error' => $e->getMessage()]), data: [], statusCode: 500);
        }
    }

    /**
     * Remove the specified role from storage.
     *
     * @param TenantsRole $role
     * @return JsonResponse
     */
    public function destroy(TenantsRole $role): JsonResponse
    {
        try {
            $this->roleService->deleteRole(role: $role);
            return jsonResponse(message: __('role.delete_success'), data: [], statusCode: 200);
        } catch (Exception $e) {
            return jsonResponse(message: __('role.delete_failure', ['error' => $e->getMessage()]), data: [], statusCode: 500);
        }
    }
}
