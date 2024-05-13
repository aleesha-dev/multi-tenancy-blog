<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTenantRequest;
use App\Models\Tenant;
use App\Models\User;
use App\Services\TenantConnectionService;
use App\Services\TenantSeederContext;
use Database\Seeders\Tenants\RoleSeeder;
use Database\Seeders\Tenants\TenantUserSeeder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class TenantController extends Controller
{

    public function __construct(private TenantConnectionService $tenantConnectionService) {}
    /**
     * Store a new tenant and user.
     *
     * @param StoreTenantRequest $request
     * @return JsonResponse
     */
    public function store(StoreTenantRequest $request): JsonResponse
    {
        try {

            Gate::authorize('create-tenant');

            $tenant = $this->createTenant(domain: $request->domain);

            $this->migrateTenantDatabase(tenant: $tenant, request: $request);

            $user = $this->createUser(request: $request, tenant: $tenant);

            return jsonResponse(__('messages.tenant_created_success'), data: [
                'tenant' => $tenant,
                'user' => $user
            ], statusCode: 201);
        } catch (Exception $e) {
            return jsonResponse(message: __('messages.tenant_creation_failed', ['error' => $e->getMessage()]), data: [], statusCode: 500);
        }
    }

    /**
     * Create a new tenant and its domain.
     *
     * @param string $domain
     * @return Tenant
     */
    private function createTenant(string $domain): Tenant
    {
        $tenant = Tenant::create();
        $tenant->createDomain(data: ['domain' => $domain]);
        return $tenant;
    }

    /**
     * Migrate the tenant's database and run the RoleSeeder and TenantUserSeeder.
     *
     * @param Tenant $tenant
     * @param Request $request
     * @return void
     */
    protected function migrateTenantDatabase(Tenant $tenant, Request $request): void
    {

        $this->initializeTenantContext($request);

        Artisan::call('tenants:migrate', [
            '--tenants' => $tenant->id
        ]);

        Artisan::call('tenants:seed', [
            '--tenants' => $tenant->id,
            '--class' => RoleSeeder::class
        ]);

        Artisan::call('tenants:seed', [
            '--tenants' => $tenant->id,
            '--class' => TenantUserSeeder::class,
        ]);


        TenantSeederContext::getInstance()->clear();
    }


    /**
     * Create a user for the tenant.
     *
     * @param Request $request
     * @param Tenant $tenant
     * @return User
     */
    private function createUser(Request $request, Tenant $tenant): User
    {
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tenant_id' => $tenant->id,
            'role' => 'user'
        ]);
    }

    /**
     * Initialize the tenant context with required data.
     *
     * @param Tenant $tenant
     * @param Request $request
     * @return void
     */
    private function initializeTenantContext(Request $request): void
    {
        $context = TenantSeederContext::getInstance();

        $context->set([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
    }
}
