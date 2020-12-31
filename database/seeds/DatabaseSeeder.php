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
        // $this->call(UsersTableSeeder::class);
        RolesTableSeeder::class,
        UsersTableSeeder::class,
        RoleUserTableSeeder::class,
        CitiesTableSeeder::class,
        PropertytypesTableSeeder::class,
        ListingsTableSeeder::class,
    }
}
