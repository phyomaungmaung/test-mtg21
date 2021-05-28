<?php 
	Route::group([
    'prefix' => 'category',
    'middleware' => ['web','auth'],
],
    function()
    {
        Route::get('/',['as' => 'category.index',
                'uses' => 'CategoryController@index'
            ]
        )->middleware('can:view-category');

        Route::get('/cates',['as' => 'category.cates',
                'uses' => 'CategoryController@cates'
            ]
        );
//            ->middleware('can:create-category');

        Route::get('/create',['as' => 'category.create',
                'uses' => 'CategoryController@create'
            ]
        )->middleware('can:create-category');
        Route::get('/list',['as' => 'category.list',
                'uses' => 'CategoryController@getList'
            ]
        )->middleware('can:view-category');
        Route::post('/store',['as' => 'category.store',
                'uses' => 'CategoryController@store'
            ]
        )->middleware('can:create-category');
        Route::post('/destroy',['as' => 'category.destroy',
                'uses' => 'CategoryController@postDelete'
            ]
        )->middleware('can:delete-category');
        Route::get('/{id}/edit',['as' => 'category.edit',
                'uses' => 'CategoryController@edit'
            ]
        )->middleware('can:edit-category');
    }
);
?>