<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'view-user',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:13:53',
                'updated_at' => '2019-05-31 08:13:53',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'delete-user',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:13:53',
                'updated_at' => '2019-05-31 08:13:53',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'edit-user',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:13:53',
                'updated_at' => '2019-05-31 08:13:53',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'create-user',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:13:53',
                'updated_at' => '2019-05-31 08:13:53',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'view-role',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:16:00',
                'updated_at' => '2019-05-31 08:16:00',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'delete-role',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:16:00',
                'updated_at' => '2019-05-31 08:16:00',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'edit-role',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:16:00',
                'updated_at' => '2019-05-31 08:16:00',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'create-role',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:16:00',
                'updated_at' => '2019-05-31 08:16:00',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'view-candidate',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:57',
                'updated_at' => '2019-05-31 08:19:57',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'delete-candidate',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:57',
                'updated_at' => '2019-05-31 08:19:57',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'edit-candidate',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:57',
                'updated_at' => '2019-05-31 08:19:57',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'create-candidate',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:57',
                'updated_at' => '2019-05-31 08:19:57',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'list-form',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:57',
                'updated_at' => '2019-05-31 08:19:57',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'view-form',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:57',
                'updated_at' => '2019-05-31 08:19:57',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'video-form',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:57',
                'updated_at' => '2019-05-31 08:19:57',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'accept-form',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:57',
                'updated_at' => '2019-05-31 08:19:57',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'review-form',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:57',
                'updated_at' => '2019-05-31 08:19:57',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'delete-form',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:57',
                'updated_at' => '2019-05-31 08:19:57',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'edit-form',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:57',
                'updated_at' => '2019-05-31 08:19:57',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'create-form',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:57',
                'updated_at' => '2019-05-31 08:19:57',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'create-mailalert',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:57',
                'updated_at' => '2019-05-31 08:19:57',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'view-comment',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:57',
                'updated_at' => '2019-05-31 08:19:57',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'create-comment',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:57',
                'updated_at' => '2019-05-31 08:19:57',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'delete-country',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:57',
                'updated_at' => '2019-05-31 08:19:57',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'edit-country',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:57',
                'updated_at' => '2019-05-31 08:19:57',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'view-country',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:58',
                'updated_at' => '2019-05-31 08:19:58',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'create-country',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:58',
                'updated_at' => '2019-05-31 08:19:58',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'delete-category',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:58',
                'updated_at' => '2019-05-31 08:19:58',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'edit-category',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:58',
                'updated_at' => '2019-05-31 08:19:58',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'view-category',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:58',
                'updated_at' => '2019-05-31 08:19:58',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'create-category',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:58',
                'updated_at' => '2019-05-31 08:19:58',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'delete-setting',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:58',
                'updated_at' => '2019-05-31 08:19:58',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'edit-setting',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:58',
                'updated_at' => '2019-05-31 08:19:58',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'view-setting',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:58',
                'updated_at' => '2019-05-31 08:19:58',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'create-setting',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:58',
                'updated_at' => '2019-05-31 08:19:58',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'list-aseanapp',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:58',
                'updated_at' => '2019-05-31 08:19:58',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'delete-aseanapp',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:58',
                'updated_at' => '2019-05-31 08:19:58',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'edit-aseanapp',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:58',
                'updated_at' => '2019-05-31 08:19:58',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'view-aseanapp',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:59',
                'updated_at' => '2019-05-31 08:19:59',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'create-aseanapp',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:59',
                'updated_at' => '2019-05-31 08:19:59',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'delete-guideline',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:59',
                'updated_at' => '2019-05-31 08:19:59',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'edit-guideline',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:59',
                'updated_at' => '2019-05-31 08:19:59',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'view-guideline',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:59',
                'updated_at' => '2019-05-31 08:19:59',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'create-guideline',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:59',
                'updated_at' => '2019-05-31 08:19:59',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'list-guideline',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:59',
                'updated_at' => '2019-05-31 08:19:59',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'judge-judge',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:59',
                'updated_at' => '2019-05-31 08:19:59',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'delete-judge',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:59',
                'updated_at' => '2019-05-31 08:19:59',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'edit-judge',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:19:59',
                'updated_at' => '2019-05-31 08:19:59',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'view-judge',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:00',
                'updated_at' => '2019-05-31 08:20:00',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'create-judge',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:00',
                'updated_at' => '2019-05-31 08:20:00',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'list-judge',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:00',
                'updated_at' => '2019-05-31 08:20:00',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'generate_semi-result',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:00',
                'updated_at' => '2019-05-31 08:20:00',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'export_final_detail-result',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:00',
                'updated_at' => '2019-05-31 08:20:00',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'export_final-result',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:00',
                'updated_at' => '2019-05-31 08:20:00',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'generate_final-result',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:00',
                'updated_at' => '2019-05-31 08:20:00',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'view-final-result',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:00',
                'updated_at' => '2019-05-31 08:20:00',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'semifinal-result',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:00',
                'updated_at' => '2019-05-31 08:20:00',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'download_judge_score_detail-report',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:01',
                'updated_at' => '2019-05-31 08:20:01',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'download_judge_score-report',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:01',
                'updated_at' => '2019-05-31 08:20:01',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'freeze-final-judge',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:01',
                'updated_at' => '2019-05-31 08:20:01',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'app-final-judge',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:01',
                'updated_at' => '2019-05-31 08:20:01',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'judge-final-judge',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:01',
                'updated_at' => '2019-05-31 08:20:01',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'delete-final-judge',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:01',
                'updated_at' => '2019-05-31 08:20:01',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'edit-final-judge',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:01',
                'updated_at' => '2019-05-31 08:20:01',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'view-final-judge',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:01',
                'updated_at' => '2019-05-31 08:20:01',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'create-final-judge',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:02',
                'updated_at' => '2019-05-31 08:20:02',
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'list-final-judge',
                'guard_name' => 'web',
                'created_at' => '2019-05-31 08:20:02',
                'updated_at' => '2019-05-31 08:20:02',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'list-user',
                'guard_name' => 'web',
                'created_at' => '2019-06-12 07:40:46',
                'updated_at' => '2019-06-12 07:40:46',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'list-candidate',
                'guard_name' => 'web',
                'created_at' => '2019-06-12 07:40:48',
                'updated_at' => '2019-06-12 07:40:48',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'list-category',
                'guard_name' => 'web',
                'created_at' => '2019-06-12 07:40:49',
                'updated_at' => '2019-06-12 07:40:49',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'list-setting',
                'guard_name' => 'web',
                'created_at' => '2019-06-12 07:40:51',
                'updated_at' => '2019-06-12 07:40:51',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'video-application',
                'guard_name' => 'web',
                'created_at' => '2019-06-12 07:43:56',
                'updated_at' => '2019-06-12 07:43:56',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'list-application',
                'guard_name' => 'web',
                'created_at' => '2019-06-12 07:43:57',
                'updated_at' => '2019-06-12 07:43:57',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'view-application',
                'guard_name' => 'web',
                'created_at' => '2019-06-12 07:43:58',
                'updated_at' => '2019-06-12 07:43:58',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'review-application',
                'guard_name' => 'web',
                'created_at' => '2019-06-12 07:44:00',
                'updated_at' => '2019-06-12 07:44:00',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'accept-application',
                'guard_name' => 'web',
                'created_at' => '2019-06-12 07:44:01',
                'updated_at' => '2019-06-12 07:44:01',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'create-application',
                'guard_name' => 'web',
                'created_at' => '2019-06-12 07:54:40',
                'updated_at' => '2019-06-12 07:54:40',
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'edit-application',
                'guard_name' => 'web',
                'created_at' => '2019-06-12 07:54:42',
                'updated_at' => '2019-06-12 07:54:42',
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'view-video',
                'guard_name' => 'web',
                'created_at' => '2019-06-12 07:58:45',
                'updated_at' => '2019-06-12 07:58:45',
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'review-video',
                'guard_name' => 'web',
                'created_at' => '2019-06-12 07:58:47',
                'updated_at' => '2019-06-12 07:58:47',
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'generate.semi-result',
                'guard_name' => 'web',
                'created_at' => '2019-07-01 18:01:13',
                'updated_at' => '2019-07-01 18:01:13',
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'list-result',
                'guard_name' => 'web',
                'created_at' => '2019-07-01 18:01:13',
                'updated_at' => '2019-07-01 18:01:13',
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'list-country',
                'guard_name' => 'web',
                'created_at' => '2019-07-08 04:25:17',
                'updated_at' => '2019-07-08 04:25:17',
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'semi_score_detail-report',
                'guard_name' => 'web',
                'created_at' => '2019-07-30 20:51:36',
                'updated_at' => '2019-07-30 20:51:36',
            ),
        ));
        
        
    }
}