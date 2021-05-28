<?php

namespace App\customVendors\setting;

use Illuminate\Support\ServiceProvider;
use SMATAR\Settings\App\Providers\SettingServiceProvider as SmatarServiceProvider;

class SettingServiceProvider extends SmatarServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->loadRoutesFrom(__DIR__ . '/web.php');

        //
    }
}
