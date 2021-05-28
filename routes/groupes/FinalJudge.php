<?php 
    
    Route::group([
        'prefix' => 'finalapp',
        'middleware' => ['web','auth'],
    ],
        function()
        {
            // ok
            Route::get('/finallist',['as' => 'finaljudge.finallist',
                    'uses' => 'FinalJudgeController@getfinalList'
                ]
            )->middleware('can:list-final-judge'); 

            Route::get('/',['as' => 'finaljudge.finalapp',
                    'uses' => 'FinalJudgeController@finalApplication'
                ]
            )->middleware('can:list-final-judge');

            // ok
            Route::get('/judged/{id}', ['as' => 'finaljudge.judged',
                'uses' => 'FinalJudgeController@judged'
            ])->middleware('can:judge-final-judge');


            Route::post('/score/{id}/save', ['as' => 'finaljudge.save',
                'uses' => 'FinalJudgeController@saveScore'

            ])->middleware('can:create-final-judge');

            Route::get('/freeze', ['as'=>'finaljudge.freez','uses'=>'FinalJudgeController@freez'])->middleware('can:freeze-final-judge');
            Route::get('/dofreeze', ['as'=>'finaljudge.dofreeze','uses'=>'FinalJudgeController@dofreeze'])->middleware('can:freeze-final-judge');
    });
 ?>