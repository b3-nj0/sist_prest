<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleGerente = Role::create(['name' => 'Gerente']);
        $roleEmpleado = Role::create(['name' => 'Empleado']);
/*____________________________________________________________________________________________*/
        $permission1 = Permission::create(['name' => 'users.obtener']);
        $permission2 = Permission::create(['name' => 'users.createUser']);
        $permission3 = Permission::create(['name' => 'users.edit']);
        $permission4 = Permission::create(['name' => 'users.delete']);
        $permission5 = Permission::create(['name' => 'users.logout']);
/*____________________________________________________________________________________________*/


        $roleAdmin->givePermissionTo($permission1, $permission2, $permission3, $permission4);
        $roleGerente->givePermissionTo($permission1, $permission2, $permission3, $permission4);
        $roleEmpleado->givePermissionTo($permission1,$permission5);

        /*
        $permission1 = Permission::create(['name' => ' users.obtener'])->syncRoles([$role1, $role2]);
        $permission2 = Permission::create(['name' => ' users.createUser'])->syncRoles([$role1, $role2]);
        $permission3 = Permission::create(['name' => ' users.edit'])->syncRoles([$role1,$role2] );
        $permission4 = Permission::create(['name' => ' users.delete'])->syncRoles([$role1,$role2]);
       */ 
    }
}
