<?php

namespace Database\Seeders\Tenants;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\ClientRepository;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Super Administrator',
                'permissions' => json_encode([
                    'create_blog',
                    'edit_blog',
                    'delete_blog',
                    'view_own_blog',
                    'view_all_blog'
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Content Creator',
                'permissions' => json_encode([
                    'create_blog',
                    'edit_blog',
                    'view_own_blog'
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Content Manager',
                'permissions' => json_encode([
                    'create_blog',
                    'edit_blog',
                    'delete_blog',
                    'view_all_blog'
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        // Attempt to insert roles
        DB::table('roles')->insert($data);

        Log::info('Roles inserted successfully');

        $client = new ClientRepository();

        $client->createPasswordGrantClient(null, 'Default password grant client', 'http://your.redirect.path');
        $client->createPersonalAccessClient(null, 'Default personal access client', 'http://your.redirect.path');
    }
}
