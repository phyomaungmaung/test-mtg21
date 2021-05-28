<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'login_bg_img',
                'type' => 'FILE',
                'label' => 'LOGIN_BG_IMG',
                'value' => 'login_bg_img.png',
                'hidden' => 0,
                'created_at' => NULL,
                'updated_at' => '2019-06-12 09:55:58',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'limit_candidate_per_cate',
                'type' => 'NUMBER',
                'label' => 'LIMIT_CANDIDATE_PER_CATE',
                'value' => '3',
                'hidden' => 1,
                'created_at' => NULL,
                'updated_at' => '2019-08-07 09:58:43',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'is_use_admin_template',
                'type' => 'BOOLEAN',
                'label' => 'IS_USE_ADMIN_TEMPLATE',
                'value' => 'true',
                'hidden' => 1,
                'created_at' => NULL,
                'updated_at' => '2019-08-07 09:58:55',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'is_auto_auload_process',
                'type' => 'BOOLEAN',
                'label' => 'IS_AUTO_AULOAD_PROCESS',
                'value' => 'true',
                'hidden' => 1,
                'created_at' => NULL,
                'updated_at' => '2019-08-07 09:59:08',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'show_not_complete',
                'type' => 'BOOLEAN',
                'label' => 'SHOW_NOT_COMPLETE',
                'value' => 'true',
                'hidden' => 1,
                'created_at' => NULL,
                'updated_at' => '2019-08-07 09:59:18',
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'can_final_judge',
                'type' => 'BOOLEAN',
                'label' => 'CAN_FINAL_JUDGE',
                'value' => 'true',
                'hidden' => 0,
                'created_at' => NULL,
                'updated_at' => '2019-07-21 14:24:21',
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'freeze_without_con',
                'type' => 'BOOLEAN',
                'label' => 'FREEZE_WITHOUT_CON',
                'value' => 'false',
                'hidden' => 1,
                'created_at' => NULL,
                'updated_at' => '2019-08-07 09:59:37',
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'limit_representer',
                'type' => 'NUMBER',
                'label' => 'LIMIT_REPRESENTER',
                'value' => '1',
                'hidden' => 1,
                'created_at' => NULL,
                'updated_at' => '2019-08-07 09:46:50',
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'started_judgement_date',
                'type' => 'DATE',
                'label' => 'STARTED_JUDGEMENT_DATE',
                'value' => '08/16/2019',
                'hidden' => 0,
                'created_at' => NULL,
                'updated_at' => '2019-08-07 09:48:14',
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'ended_judgement_date',
                'type' => 'DATE',
                'label' => 'ENDED_JUDGEMENT_DATE',
                'value' => '09/19/2019',
                'hidden' => 0,
                'created_at' => NULL,
                'updated_at' => '2019-08-07 09:48:53',
            ),
            10 => 
            array (
                'id' => 11,
                'code' => 'closed_form_date',
                'type' => 'DATE',
                'label' => 'CLOSED_FORM_DATE',
                'value' => '08/08/2019',
                'hidden' => 0,
                'created_at' => NULL,
                'updated_at' => '2019-08-07 09:49:42',
            ),
            11 => 
            array (
                'id' => 12,
                'code' => 'semi_final_result_date',
                'type' => 'DATE',
                'label' => 'SEMI_FINAL_RESULT_DATE',
                'value' => '09/11/2019',
                'hidden' => 0,
                'created_at' => NULL,
                'updated_at' => '2019-08-07 09:50:39',
            ),
            12 => 
            array (
                'id' => 13,
                'code' => 'video_upload_max_size',
                'type' => 'NUMBER',
                'label' => 'VIDEO_UPLOAD_MAX_SIZE',
                'value' => '2100000000',
                'hidden' => 1,
                'created_at' => '2019-06-13 16:10:39',
                'updated_at' => '2019-08-07 10:00:11',
            ),
            13 => 
            array (
                'id' => 14,
                'code' => 'final_judge_date',
                'type' => 'DATE',
                'label' => 'FINAL_JUDGE_DATE',
                'value' => '10/30/2019',
                'hidden' => 0,
                'created_at' => '2019-07-30 13:01:53',
                'updated_at' => '2019-08-07 09:52:03',
            ),
            14 => 
            array (
                'id' => 15,
                'code' => 'industries',
                'type' => 'SELECT',
                'label' => 'industries',
                'value' => '{"Korea":"Korea","Japan":"Japan"}',
                'hidden' => 0,
                'created_at' => '2019-08-07 09:54:37',
                'updated_at' => '2019-08-07 09:57:08',
            ),
        ));
        
        
    }
}