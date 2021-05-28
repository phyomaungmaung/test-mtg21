<?php

namespace App\customVendors\setting;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use  SMATAR\Settings\App\Http\Controllers\SettingsController as SmatarController;
use SMATAR\Settings\App\Http\Requests\SettingRequest;
use SMATAR\Settings\App\Setting;

class SettingController extends SmatarController
{
    /**
     * @var array
     * available setting types
     */
    private $types = ['TEXT' => 'Text', 'TEXTAREA' => 'Text Area',
        'BOOLEAN' => 'Boolean', 'NUMBER' => 'Number',
        'DATE' => 'Date', 'SELECT' => 'Select Options', 'FILE' => 'File'];

    public function index(Request $request)
    {
        $hidden = [0];
        if(\Auth::user()->is_super_admin == 1 || config('settings.show_hidden_records')) {
            $hidden[] = 1;
        }

        $settings = Setting::whereIn('hidden', $hidden);
//        dd($settings->get()->toArray(),$hidden);
        $search_query = $request->search;

        $search = [
            'code' => '',
            'type' => '',
            'label' => '',
            'value' => '',
        ];

        if (!empty($search_query)) {
            foreach ($search_query as $key => $value) {
                if (!empty($value)) {
                    $search[$key] = $value;
                    $settings->where($key, 'like', '%' . strip_tags(trim($value)) . '%');
                }
            }
        }

        $types = $this->types;

        $settings = $settings->paginate(config('settings.per_page', 10));

        return view('settings::index')->with(compact('settings', 'search', 'types'));
    }

    public function update(SettingRequest $request, Setting $setting)
    {
      return   parent::update($request,$setting);

    }


}
