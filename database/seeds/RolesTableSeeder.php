<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$roles=["Admin","Reviewer","Representer","Candidate","Judge","Final Judge"];

    	foreach ($roles as $role) {
    		DB::table('roles')->insert([
	            'name'=>$role,
	            'guard_name'=>"web",
	            'created_at' => Carbon::now(),
	            'updated_at' => Carbon::now(),
	        ]);
    	}
        

    }
}
