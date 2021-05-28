<?php

use Illuminate\Database\Seeder;

class ModelHasRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('model_has_roles')->delete();
        
        \DB::table('model_has_roles')->insert(array (
            0 => 
            array (
                'role_id' => 1,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 8,
            ),
            1 => 
            array (
                'role_id' => 1,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 9,
            ),
            2 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 41,
            ),
            3 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 42,
            ),
            4 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 43,
            ),
            5 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 44,
            ),
            6 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 50,
            ),
            7 => 
            array (
                'role_id' => 3,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 53,
            ),
            8 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 88,
            ),
            9 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 91,
            ),
            10 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 92,
            ),
            11 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 93,
            ),
            12 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 94,
            ),
            13 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 95,
            ),
            14 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 96,
            ),
            15 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 97,
            ),
            16 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 100,
            ),
            17 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 101,
            ),
            18 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 102,
            ),
            19 => 
            array (
                'role_id' => 4,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 103,
            ),
            20 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 99,
            ),
            21 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 104,
            ),
            22 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 105,
            ),
            23 => 
            array (
                'role_id' => 5,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 106,
            ),
            24 => 
            array (
                'role_id' => 6,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 107,
            ),
            25 => 
            array (
                'role_id' => 6,
                'model_type' => 'App\\Entities\\User',
                'model_id' => 108,
            ),
        ));
        
        
    }
}