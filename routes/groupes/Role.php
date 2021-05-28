<?php 
	Route::group([
    'prefix' => 'role',
    'middleware' => ['web','auth'], 
    ], 
    function()
    {
        
        Route::get('/list',
                    ['as' => 'role.list', 
                        'uses' => 'RoleController@roleList'
                    ]
                )->middleware('can:view-role');

        Route::get('/',
                    ['as' => 'role.index', 
                        'uses' => 'RoleController@index'
                    ]
                )->middleware('can:view-role');

        Route::get('/create',
                    ['as' => 'role.create', 
                        'uses' => 'RoleController@create'
                    ]
                )->middleware('can:create-role');

        Route::post('/',
                    ['as' => 'role.store', 
                        'uses' => 'RoleController@store'
                    ]
                )->middleware('can:create-role');

        Route::get('/{id}/edit',
                    ['as' => 'role.edit', 
                        'uses' => 'RoleController@edit'
                    ]
                )->middleware('can:edit-role');

        Route::put('/{id}',
                    ['as' => 'role.update', 
                        'uses' => 'RoleController@update'
                    ]
                )->middleware('can:edit-role');

        Route::post('/destroy',
                    ['as' => 'role.destroy',
                        'uses' => 'RoleController@postDelete'
                    ]
                )->middleware('can:delete-role');

        // Route::resource('role', 'RoleController');
        
    }
);
 ?>