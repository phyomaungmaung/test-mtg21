<?php

namespace App\customVendors\setting;

use SMATAR\Settings\App\Setting;
use  SMATAR\Settings\App\SettingsHelper as SmatarHelper;

class SettingHelper extends SmatarHelper
{

    public function set($code, $value ,$type="TEXT")
    {
//        @todo: update more logic
//       $old =  Setting::where('code',$code)->first();
       $old =  Setting::firstOrNew(['code'=>$code]);
        $old->value = $value;
        if($old->label== null){
            $old->label= $code;
        }
        if($old->type== null) {
            $old->type = $type;
        }
        $old= $this->__validateData($old);
        $old->save();
    }

    private function __validateData(Setting $setting){
        if($setting == null){
            return $setting;
        }
        switch ($setting->type) {
            case 'BOOLEAN':
                if(is_array($setting)){
                    $setting['value'] = isset($setting['value']) && $setting['value'] ? 'true' : 'false';
                }else{
                    $setting->value = isset($setting->value) && $setting->value ? 'true' : 'false';
                }
                break;
            case 'SELECT':
                $value = [];

                $items = $setting->{$setting->code};

                if (!empty($items) && is_array($items)) {
                    foreach ($items as $item) {
                        if (empty($item['key']) || empty($item['value'])) {
                            continue;
                        }
                        $value[$item['key']] = $item['value'];
                    }
                }
                if (empty($value)) {
                    $setting['value'] = '';
                } else {
                    $setting['value'] = json_encode($value);
                }
                break;
        }
        return $setting;
    }

}
