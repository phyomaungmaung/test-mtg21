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
        $this->call(SettingsTableSeeder::class);
//        $this->call(RolesTableSeeder::class);
//        $this->call(UsersTableSeeder::class);
//        $this->call(CountriesTableSeeder::class);
//        $this->call(CategoriesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(GuidelinesTableSeeder::class);
//        $this->call(ModelHasRolesTableSeeder::class);
    }
}
