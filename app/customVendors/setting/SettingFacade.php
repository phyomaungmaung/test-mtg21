<?php

namespace App\customVendors\setting;

use  SMATAR\Settings\App\Facades\Setting as SmatarSettingFacade;

class SettingFacade extends SmatarSettingFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return SettingHelper::class;

//        return parent::getFacadeAccessor();

    }

}
