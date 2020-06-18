<?php

use App\Models\Administration\Permissions\PermissionGroup;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DashboardPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionGroup = PermissionGroup::create(['name' => 'General']);

        Permission::create([
            'name' => 'dashboard.view',
            'show_name' => 'Ver dashboard',
            'guard_name' => 'web',
            'permission_group_id' => $permissionGroup->id
        ]);

    }
}
