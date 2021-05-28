<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()    {
        DB::table('users')->insert([
            'username'=>"vitou",
            'email'=>"vitoutry@gmail.com",
            'password'=>bcrypt("vitou"),
            'active'=>"1",
            'is_super_admin'=>"1",
        ]);
        DB::table('users')->insert([
            'username'=>"manith",
            'email'=>"manithchhuon@gmail.com",
            'password'=>bcrypt("111111"),
            'active'=>"1",
            'is_super_admin'=>"1",
        ]);

    }
}
