<?php

use App\Models\Administration\Permissions\PermissionGroup;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UsersPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionGroup = PermissionGroup::create(['name' => 'Usuarios']);

        Permission::create([
            'name' => 'administration.users.view',
            'show_name' => 'Ver Usuarios',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);

        Permission::create([
            'name' => 'administration.users.create',
            'show_name' => 'Crear Usuarios',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);

        Permission::create([
            'name' => 'administration.users.edit',
            'show_name' => 'Editar Usuarios',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);

        Permission::create([
            'name' => 'administration.users.delete',
            'show_name' => 'Eliminar Usuarios',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);
    }
}
