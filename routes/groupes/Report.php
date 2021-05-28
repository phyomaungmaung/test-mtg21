<?php


Route::group([
    'prefix' => 'report',
    'middleware' => ['web','auth'],
],
    function()
    {

        Route::get('judge_score', ['as'=>'report.judgeScore','uses'=>'ReportController@exportSemiJudgeScored']);
        Route::get('judge_score_detail', ['as'=>'report.judgeScoreDetail','uses'=>'ReportController@exportSemiJudgeScoredDetail']) ->middleware('can:semi_score_detail-report');
        Route::get('final_score', ['as'=>'report.finalScore','uses'=>'ReportController@exportFinal']);
        Route::get('final_score_detail', ['as'=>'report.finalScoreDetail','uses'=>'ReportController@exportFinalScoredDetail']);
    });
 ?>