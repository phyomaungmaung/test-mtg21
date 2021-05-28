<?php
namespace App\filters;
/**
 * Created by PhpStorm.
 * User: vitoutry
 * Date: 6/12/19
 * Time: 11:42 PM
 */
use \JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter;
//use hasR
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class MyGate extends GateFilter
{

    protected function isVisible($item)
    {
        if( isset($item['role'])){
            $roles = is_array($item['role'])
                ? $item['role']
                : explode('|', $item['role']);
            return Auth::user()->hasAnyRole($roles);
        }
       return parent::isVisible($item);

    }


}