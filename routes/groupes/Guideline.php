<?php
Route::group([
    'prefix' => 'guideline',
    'middleware' => ['web','auth'],
],
    function (){
        Route::get('/',['as' => 'guideline.index',
                'uses' => 'GuidelineController@index'
            ]
        )
            ->middleware('can:list-guideline');

        Route::get('/{id}/view',['as' => 'guideline.view',
                'uses' => 'GuidelineController@view'
            ]
        )->middleware('can:view-guideline');

        Route::get('/create',['as'=>'guideline.create','uses'=>'GuidelineController@create'])
            ->middleware('can:create-guideline');

        Route::get('/list',['as' => 'guideline.list',
                'uses' => 'GuidelineController@getList'
            ]
        )
            ->middleware('can:list-guideline');

        Route::post('/store',['as' => 'guideline.store',
                'uses' => 'GuidelineController@store'
            ]
        )
            ->middleware('can:create-guideline');

        Route::post('/destroy',['as' => 'guideline.destroy',
                'uses' => 'GuidelineController@postDelete'
            ]
        )
            ->middleware('can:delete-guideline');

        Route::get('/{id}/edit',['as' => 'guideline.edit',
                'uses' => 'GuidelineController@edit'
            ]
        )->middleware('can:edit-guideline');

        Route::get('/help',['as' => 'guideline.help',
                'uses' => 'GuidelineController@help'
            ]
        );
    });

    Route::group(['middleware' => ['web', 'auth' ]], function () {
        Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
        Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
        // list all lfm routes here...
    });

?>