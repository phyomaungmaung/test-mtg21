<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->insert([ 
		    'name'=>"Brunei Darussalam",
		    'bref'=>'BN',
		    'flag'=>'images/flag/brunei.jpg'
		]);
		DB::table('countries')->insert([ 
		    'name'=>"Cambodia",
		    'bref'=>'KH',
		    'flag'=>'images/flag/cambodia.jpg'      		
		]);
		DB::table('countries')->insert([ 
		    'name'=>"Indonesia",
		    'bref'=>'ID',
		    'flag'=>'images/flag/indonesia.jpg'      		
		]);
		DB::table('countries')->insert([ 
		    'name'=>"Lao PDR",
		    'bref'=>'LA',
		    'flag'=>'images/flag/lao.jpg'      		
		]);
		DB::table('countries')->insert([ 
		    'name'=>"Malaysia",
		    'bref'=>'MY',
		    'flag'=>'images/flag/malaysia.jpg'      		
		]);
		DB::table('countries')->insert([ 
		    'name'=>"Myanmar",
		    'bref'=>'MM',
		    'flag'=>'images/flag/myanmar.jpg'      		
		]);
		DB::table('countries')->insert([ 
		    'name'=>"Philippines",
		    'bref'=>'PH',
		    'flag'=>'images/flag/philippines.jpg'      		
		]);
		DB::table('countries')->insert([ 
		    'name'=>"Singapore",
		    'bref'=>'SG',
		    'flag'=>'images/flag/singapore.jpg'      		
		]);
		DB::table('countries')->insert([ 
		    'name'=>"Thailand",
		    'bref'=>'TH',
		    'flag'=>'images/flag/thailand.jpg'      		
		]);
		DB::table('countries')->insert([ 
		    'name'=>"Viet Nam",
		    'bref'=>'VN',
		    'flag'=>'images/flag/vietname.jpg'      		
		]);
    }
}

