<?php 
	Route::group([
    'prefix' => 'country',
    'middleware' => ['web','auth'], 
    ], 
    function()
    {
        Route::get('/',['as' => 'country.index', 
                    'uses' => 'CountryController@index'
                ]
            )->middleware('can:view-country');

        Route::get('/create',['as' => 'country.create', 
                    'uses' => 'CountryController@create'
                ]
            )->middleware('can:create-country');

        Route::get('/list',['as' => 'country.list', 
                    'uses' => 'CountryController@getList'
                ]
            )->middleware('can:view-country');

        Route::post('/store',['as' => 'country.store', 
                    'uses' => 'CountryController@store'
                ]
            )->middleware('can:create-country');

        Route::post('/destroy',['as' => 'country.destroy', 
                    'uses' => 'CountryController@postDelete'
                ]
            )->middleware('can:delete-country');
        
        Route::get('/{id}/edit',['as' => 'country.edit', 
                    'uses' => 'CountryController@edit'
                ]
            )->middleware('can:edit-country');
        Route::post('/listJson',['as' => 'country.listJson',
                'uses' => 'CountryController@getListJson'
            ]
        );
        //->middleware('can:view-country');
    }
);
?>