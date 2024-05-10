<?php

namespace Database\Seeders\Tenants;

use App\Services\TenantConnectionService;
use App\Services\TenantSeederContext;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TenantUserSeeder extends Seeder
{

    public function __construct(private Request $request) {}
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $context = TenantSeederContext::getInstance();

        DB::table('users')->insertGetId([
            'name' => $context->get('name', 'Admin'),
            'email' => $context->get('email', 'admin@tenant.com'),
            'password' => Hash::make($context->get('password', 'password')),
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
