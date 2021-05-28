<?php 
namespace App\Repositories;

use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;
use App\Entities\Video;

class VideoRepository extends Repository {


    public function model() {
        return 'App\Entities\Video';
    }



//    public function firstOrCreate($user_id=null){
//        if($user_id==null){
//            $user_id = \Auth::id();
//        }
//        $applicationInfor= Application::where('user_id',$user_id)->whereNotIn('status',array('version'))->first();
//        if(null==$applicationInfor){
//            $applicationInfor =Application::create(array('user_id'=>$user_id,'status'=>'draft'));
//        }
//        return ($applicationInfor);
//    }
    
}