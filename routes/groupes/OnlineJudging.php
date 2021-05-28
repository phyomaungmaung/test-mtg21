<?php 
    Route::group([
        'prefix' => 'aseanapp',
        'middleware' => ['web','auth'],
    ],
        function()
        {
            Route::get('/aseanlist',['as' => 'application.aseanlist',
                    'uses' => 'OnlineJudgingController@getAseanList'
                ]
            )->middleware('can:view-aseanapp'); 
            Route::get('/judgedlist',['as' => 'application.judgedlist',
                    'uses' => 'OnlineJudgingController@getJudgedList'
                ]
            )->middleware('can:list-aseanapp');

            Route::get('/',['as' => 'application.aseanapp',
                    'uses' => 'OnlineJudgingController@aseanApplication'
                ]
            )->middleware('can:list-aseanapp');

            Route::get('/{id}/aseanview',['as' => 'application.aseanview',
                'uses' => 'OnlineJudgingController@aseanview'
                ]
            )->middleware('can:view-aseanapp');

            Route::get('/score/{id}', ['as' => 'judge.score', 'uses' => 'OnlineJudgingController@judging' ] )
            ->middleware('can:judge-judge');

            Route::post('/score/{id}/save', ['as' => 'judge.save',  'uses' => 'OnlineJudgingController@saveScore' ] )
            ->middleware('can:judge-judge');

            Route::get('/message', ['as' => 'judge.message',  'uses' => 'OnlineJudgingController@judgeMessage' ]);

    });
 ?>