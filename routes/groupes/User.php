<?php 
	Route::group([
	    'prefix' => 'user',
	    'middleware' => ['web','auth'], 
	    ], 
	    function()
	    {
	    
	        Route::get('create',['as'=>'register','uses'=>'UserController@showRegistrationForm'])->middleware('can:create-user');

	        Route::post('create', ['as'=>'register','uses'=>'UserController@register'])->middleware('can:create-user');

	        Route::get('/', ['as'=>'user.index','uses'=>'UserController@index'])->middleware('can:create-user');

	        Route::get('/list',['as' => 'user.list', 
	                    'uses' => 'UserController@getList'
	                ]
	            )->middleware('can:view-user');

	        Route::post('/destroy',['as' => 'user.destroy', 
	                    'uses' => 'UserController@postDelete'
	                ]
	            )->middleware('can:delete-user');
	        
	        Route::get('/{id}/edit',['as' => 'user.edit', 
	                    'uses' => 'UserController@edit'
	                ]
	            );
	        Route::get('/profile',['as' => 'user.profile', 
	                    'uses' => 'UserController@profile'
	                ]
	            );
//            Route::get('/{id}/profile',['as' => 'user.edit.profile',
//                    'uses' => 'UserController@editProfile'
//                ]
//            );
	        Route::post('/profile',['as' => 'user.editprofile', 
	                    'uses' => 'UserController@editProfile'
	                ]
	            );

	        Route::get('/password',['as' => 'user.password', 
	                    'uses' => 'UserController@password'
	                ]
	            );
	        Route::post('/password',['as' => 'user.changepassword', 
	                    'uses' => 'UserController@changepassword'
	                ]
	            );
            Route::post('/listJson',['as' => 'user.listJson',
                    'uses' => 'UserController@getListJson'
                ]
            );
	    });
 ?>