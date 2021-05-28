<?php 
namespace App\Repositories;

use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;
use App\Entities\Application;
use Illuminate\Support\Collection;

class ApplicationRepository extends Repository {


    public function model() {
        return 'App\Entities\Application';
    }

    public function firstOrCreate($user_id=null){
        if($user_id==null){
            $user_id = \Auth::id();
        }
        $applicationInfor= Application::where('user_id',$user_id)->whereNotIn('status',array('version'))->first();
        if(null==$applicationInfor){
            $applicationInfor =Application::create(array('user_id'=>$user_id,'status'=>'draft'));
        }
        return ($applicationInfor);
    }

    public function getAll($country_id= null):Collection{

        if($country_id!=null){
            $applications = $this->makeModel()->whereHas('user', function($u) use ($country_id){
                $u->whereHas('roles',function ($r){
                    $r->where('name','Candidate');
                })
                    -> where('country_id',$country_id);
            })->get();
        }else{
            $applications = $this->makeModel()->whereHas('user', function($u){
                $u->whereHas('roles',function ($r){
                    $r->where('name','Candidate');
                });
            })->get();
        }

    }

    public function getAllAccepted($country_id= null){
        return $this->getAll($country_id)->whereIn('status',['accepted','comment']);
    }

    public function getNnumberAppInCat($cat_id){

        return \DB::table('users')
            ->join('applications','users.id','=','applications.user_id')
            ->where('applications.status','accepted')
            ->where('users.category_id',$cat_id)
            ->count();
    }
    
}