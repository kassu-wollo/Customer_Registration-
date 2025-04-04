<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Permissions
        Permission::create(['name' => 'create-user']);
        Permission::create(['name' => 'edit-user']);
        Permission::create(['name' => 'delete-user']);

        // Create Roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        // Assign permissions to roles
        $adminRole->givePermissionTo('create-user', 'edit-user', 'delete-user');
        $userRole->givePermissionTo('create-user');

        // Assign roles to users
        $admin = User::find(1);
        $admin->assignRole('admin');
    }
}
