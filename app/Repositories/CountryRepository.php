<?php 
namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;


class CountryRepository extends Repository {

    public function model() {
        return 'App\Entities\Country';
    }

    public function getList(bool $is_industry= false):array {
        $industries =[];

        if(!$is_industry){
            $industries= \Settings::get('industries',[]);
        }
        return $this->makeModel()->whereNotIn('name',$industries)->pluck('name','id')->toArray();
    }

    public function getListSelect(bool $is_industry= false):array {
        $industries =[];

        if(!$is_industry){
            $industries= \Settings::get('industries',[]);
        }
        return $this->makeModel()->whereNotIn('name',$industries)->select('name AS text','id')->get()->toArray();
    }
    
}