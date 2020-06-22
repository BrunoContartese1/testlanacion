<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $user =  User::create([
                    'name' => 'Contartese, Bruno Andrés',
                    'username' => 'bcontartese',
                    'email' => 'bcontartese@codesolutions.com.ar',
                    'password' => bcrypt('secret')
                ]);

        $role = Role::create([
            'name' => 'Administrador'
        ]);

        $role->syncPermissions(Permission::all());

        $user->syncRoles("Administrador");

        $user =  User::create([
            'name' => 'Demo, Demo',
            'username' => 'demo',
            'email' => 'demo@demo.com.ar',
            'password' => bcrypt('demo')
        ]);

        $user->syncRoles("Administrador");


    }
}
