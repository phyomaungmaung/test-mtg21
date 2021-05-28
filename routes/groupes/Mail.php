<?php
Route::group([
    'prefix' => 'mail',
    'middleware' => ['web','auth'],
],
    function()
    {
        Route::get('/',['as' => 'mail.sending',
                'uses' => 'MailController@index'
            ]
        )->middleware('can:create-mailalert');;

        Route::post('/alert',['as' => 'mail.alert',
                'uses' => 'MailController@alert'
            ]
        )->middleware('can:create-mailalert');;

    });


?>