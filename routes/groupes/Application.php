<?php
/*
 * Application
 */
Route::group([
    'prefix'=>'application',
    'middleware'=>['web','auth']
],
    function (){
        Route::get('/',['as'=>'application.index','uses'=>'ApplicationController@index'])->middleware('can:list-form');
        Route::get('/list',['as' => 'application.list', 'uses' => 'ApplicationController@getList' ]
        ) ->middleware('can:list-form')
        ;

        Route::get('/create',['as'=>'application.create','uses'=>'ApplicationController@create'])->middleware('role:Candidate');
        //->middleware('can:create-form'); // everyone can create own application
        Route::post('/store',['as' => 'application.store', 'uses' => 'ApplicationController@store' ] );//->middleware('can:create-form');
        Route::get('/{id}/view',['as' => 'application.view', 'uses' => 'ApplicationController@view'] )->middleware('can:view-form');

        Route::post('/upload',['as' => 'application.uploadfile',  'uses' => 'ApplicationController@uploadfile'])->middleware('can:create-form');
        Route::post('/draft',['as' => 'application.draft',  'uses' => 'ApplicationController@draft' ] )->middleware('can:create-form');

        // form submission @todo: check route and controller
        Route::get('formcreate',['as'=>'formSubmission.create','uses'=>'FormSubmissionController@create'])->middleware('can:create-form');

        // with pdf
        Route::get('/{id}/pdfview',['as'=>'application.pdfview','uses'=>'ApplicationController@pdfview'])->middleware('can:view-form');


        Route::post('/accept',['as' => 'application.accept', 'uses' => 'ApplicationController@accept'  ]
        );//->middleware('can:accept-form');

    });
/*
 *  for comments
 */

	Route::group([
        'prefix' => 'comment',
        'middleware' => ['web','auth'],
    ],
        function()
        {
            Route::get('/{id}/view',['as' => 'comment.view',
                    'uses' => 'ApplicationController@view'
                ]
            )->middleware('can:view-comment');

            Route::post('addcomment',['as'=>'comment.add','uses'=>'CommentController@addcomment'])
                ->middleware('can:create-comment');
        }
    );

 ?>