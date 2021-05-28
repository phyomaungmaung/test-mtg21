<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
		    'name'=>"Public Sector",
		    'abbreviation'=>'PUB',
//		    'created_by'=>'1',
		]);
		DB::table('categories')->insert([
			'name'=>"Private Sector",
			'abbreviation'=>'PRV',
//			'created_by'=>'1',
		]);
		DB::table('categories')->insert([
			'name'=>"Corporate Social Responsible",
			'abbreviation'=>'CSR',
//			'created_by'=>'1',
		]);
		DB::table('categories')->insert([
			'name'=>"Digital Content",
			'abbreviation'=>'DLC',
//			'created_by'=>'1',
		]);
		DB::table('categories')->insert([
			'name'=>"Start-up Company",
			'abbreviation'=>'STC',
//			'created_by'=>'1',
		]);
		DB::table('categories')->insert([
			'name'=>"Research and Development",
			'abbreviation'=>'RND',
//			'created_by'=>'1',
		]);

    }
}

