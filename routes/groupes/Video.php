<?php
Route::group([ 'prefix'=>'video',  'middleware'=>['web','auth'] ], function (){

        Route::get('/',['as' => 'video.index', 'uses' => 'VideoController@index' ] )->middleware('can:list-video');
        Route::get('/list',['as' => 'video.list', 'uses' => 'VideoController@getList' ] )->middleware('can:list-video');
//        Route::post('/upload',['as' => 'video.store', 'uses' => 'VideoController@store' ] );
        Route::post('/upload',['as' => 'video.upload',  'uses' => 'VideoController@upload']); // everyone can upload video in form
        Route::get('/{id}/view',['as' => 'video.view', 'uses' => 'VideoController@view' ] );
        Route::get('/{id}/player',['as' => 'video.player',  'uses' => 'VideoController@player']);


    });
 ?>