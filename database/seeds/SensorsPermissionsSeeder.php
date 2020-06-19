<?php

use App\Models\Administration\Permissions\PermissionGroup;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SensorsPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionGroup = PermissionGroup::create(['name' => 'Sensores']);

        Permission::create([
            'name' => 'administration.sensors.view',
            'show_name' => 'Ver Sensores',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);

        Permission::create([
            'name' => 'administration.sensors.create',
            'show_name' => 'Crear Sensores',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);

        Permission::create([
            'name' => 'administration.sensors.edit',
            'show_name' => 'Editar Sensores',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);

        Permission::create([
            'name' => 'administration.sensors.delete',
            'show_name' => 'Eliminar Sensores',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);
    }
}
