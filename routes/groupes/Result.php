<?php 
	Route::group([
    'prefix' => 'result',
    'middleware' => ['web','auth'],
],
    function()
    {
        Route::get('/',['as' => 'result.index',
                'uses' => 'ResultController@index'
            ]
        )->middleware('can:list-result');


        Route::get('/list/semi',['as' => 'result.semi.list',
                'uses' => 'ResultController@getSemiList'
            ]
        )->middleware('can:list-result');

        Route::get('/list/final',['as' => 'result.final.list',
                'uses' => 'ResultController@getSemiList'
            ]
        )->middleware('can:list-result');

        Route::get('/list/final/realtime',['as' => 'result.final.list.realtime',
                'uses' => 'ResultController@finalResultList'
            ]
        )->middleware('can:list-result');


        Route::get('/generate/semi',['as' => 'result.semi.generate',
                'uses' => 'ResultController@generateSemiResult'
            ]
        )->middleware('can:generate.semi-result');


        Route::get('/generate/final',['as' => 'result.final.generate',
                'uses' => 'ResultController@generateFinalResult'
            ]
        )->middleware('can:generate.semi-result');

    }
);
?>