<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*Permissions*/
         $this->call(DashboardPermissionsSeeder::class);
         $this->call(UsersPermissionsSeeder::class);
         $this->call(ProfilesPermissionsSeeder::class);

         $this->call(UsersTableSeeder::class);
    }
}
