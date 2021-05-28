<?php 
	Route::group([
	    'prefix' => 'candidate',
	    'middleware' => ['web','auth'], 
	    ], 
	    function()
	    {
	 
	        Route::get('create',['as'=>'candidate.create','uses'=>'CandidateController@showRegistrationForm'])->middleware('can:create-candidate');

	        Route::post('create', ['as'=>'candidate.store','uses'=>'CandidateController@register'])->middleware('can:create-candidate');

	        Route::get('/', ['as'=>'candidate.index','uses'=>'CandidateController@index'])->middleware('can:view-candidate');

	        Route::get('/list',['as' => 'candidate.list', 
	                    'uses' => 'CandidateController@getList'
	                ]
	            )->middleware('can:view-candidate');

	        Route::post('/destroy',['as' => 'candidate.destroy', 
	                    'uses' => 'CandidateController@postDelete'
	                ]
	            )->middleware('can:delete-candidate');

            Route::get('/{id}/destroy',['as' => 'candidate.destroyget',
                    'uses' => 'CandidateController@getDelete'
                ]
            )->middleware('can:delete-candidate');

            Route::get('/{id}/edit',['as' => 'candidate.edit',
	                    'uses' => 'CandidateController@edit'
	                ]
	            )->middleware('can:edit-candidate');

	    });
 ?>