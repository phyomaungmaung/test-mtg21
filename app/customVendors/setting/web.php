<?php

Route::group(['middleware' => config('settings.middleware')], function () {
    Route::resource(config('settings.route'), 'App\customVendors\setting\SettingController');
    Route::get(config('settings.route') . '/download/{setting}', 'App\customVendors\setting\SettingController@fileDownload');
});
