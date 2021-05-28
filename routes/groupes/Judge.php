<?php
/*
 * Application
 */
Route::group([
    'prefix'=>'judge',
    'middleware'=>['web','auth']
],
function (){
    Route::get('/',['as'=>'judge.index','uses'=>'JudgeController@index'])->middleware('can:list-judge');
    Route::get('list',['as'=>'judge.list','uses'=>'JudgeController@getList'])->middleware('can:list-judge');
    Route::get('create',['as'=>'judge.create','uses'=>'JudgeController@showRegistrationForm'])->middleware('can:create-judge');

    Route::get('{id}/edit/{type}', ['as' => 'judge.edit', 'uses' => 'JudgeController@edit' ] )->middleware('can:edit-judge');

//    Route::post('listuser/{id}',['as'=>'judge.listuser.id','uses'=>'JudgeController@listuser'])->middleware('can:create-judge');
//    json to validate create judge
    Route::post('listcate/{id}',['as'=>'judge.listcate','uses'=>'JudgeController@listcate'])->middleware('can:create-judge');
    Route::post('listcateUsed',['as'=>'judge.listcat.used','uses'=>'JudgeController@listCateUsed'])->middleware('can:create-judge');

    Route::post('saveexisted',['as'=>'judge.saveexisted','uses'=>'JudgeController@saveExisted'])->middleware('can:create-judge');
    Route::post('register', ['as'=>'judge.store','uses'=>'JudgeController@register'])->middleware('can:create-judge');

    Route::get('/jlist', ['as'=>'judge.jlist','uses'=>'JudgeController@jlist'])->middleware('can:list-judge');
    Route::get('/judgelist',['as' => 'judge.judgelist', 'uses' => 'JudgeController@getListJudge'  ] )->middleware('can:list-judge');
    Route::post('/destroy',['as' => 'judge.destroy',  'uses' => 'JudgeController@postDelete' ] )->middleware('can:delete-judge');
//    Route::get('/{id}/edit',['as' => 'judge.edit', 'uses' => 'JudgeController@edit'  ] )->middleware('can:edit-judge');
    Route::post('/{id}/edit',['as' => 'judge.postedit', 'uses' => 'JudgeController@update'  ] )->middleware('can:edit-judge');
    Route::post('listcountry',['as'=>'judge.listcountry','uses'=>'JudgeController@listcountry'])->middleware('can:create-judge');
    Route::get('test',['as'=>'judge.test','uses'=>'JudgeController@test'])->middleware('can:create-judge');


    Route::get("clean",['as'=> 'judge.clean',"uses"=> "JudgeController@cleanUnusedScore"])->middleware('can:list-judge');

});



 ?>