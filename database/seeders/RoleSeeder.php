<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'Organizador']);
        $role2 = Role::create(['name' => 'Fotografo']);
        $role3 = Role::create(['name' => 'Cliente']);

        $permision1 = Permission::create(['name' => 'access-profile']);
        $permision2 = Permission::create(['name' => 'CRUD-event']);
        $permision3 = Permission::create(['name' => 'photographer-events']);

        $role1->givePermissionTo(['access-profile', 'CRUD-event']);
        $role2->givePermissionTo(['access-profile', 'photographer-events']);
    }
}
