<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create airport permissions
        Permission::create(['name' => 'view airports']);
        Permission::create(['name' => 'view airport']);
        Permission::create(['name' => 'create airport']);
        Permission::create(['name' => 'update airport']);
        Permission::create(['name' => 'delete airport']);
        //create airlines permissions
        Permission::create(['name' => 'view airlines']);
        Permission::create(['name' => 'view airline']);
        Permission::create(['name' => 'create airline']);
        Permission::create(['name' => 'update airline']);
        Permission::create(['name' => 'delete airline']);
        //create flights permissions
        Permission::create(['name' => 'view flights']);
        Permission::create(['name' => 'view flight']);
        Permission::create(['name' => 'create flight']);
        Permission::create(['name' => 'update flight']);
        Permission::create(['name' => 'delete flight']);

        // create roles and assign created permissions
        // this can be done as separate statements
        $role1 = Role::create(['name' => 'admin']);
        $role1->givePermissionTo([
        	'view flights',
        	'view flight',
        	'create flight',
        	'update flight',
        	'delete flight',]);

        // or may be done by chaining
        $role2 = Role::create(['name' => 'operations']);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example User',
            'email' => 'test@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $user->assignRole($role2);

        $user2 = \App\Models\User::factory()->create([
            'name' => 'Example Test2 User',
            'email' => 'test2@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $user2->assignRole($role2);

        $user3 = \App\Models\User::factory()->create([
            'name' => 'Example test3 User',
            'email' => 'test3@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $user3->assignRole($role2);
    }
}
