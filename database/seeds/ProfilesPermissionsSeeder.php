<?php

use App\Models\Administration\Permissions\PermissionGroup;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ProfilesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionGroup = PermissionGroup::create(['name' => 'Perfiles']);

        Permission::create([
            'name' => 'administration.profiles.view',
            'show_name' => 'Ver Perfiles',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);

        Permission::create([
            'name' => 'administration.profiles.create',
            'show_name' => 'Crear Perfiles',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);

        Permission::create([
            'name' => 'administration.profiles.edit',
            'show_name' => 'Editar Perfiles',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);

        Permission::create([
            'name' => 'administration.profiles.delete',
            'show_name' => 'Eliminar Perfiles',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);
    }
}
