<?php 
namespace App\Repositories;

use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;
use App\Entities\Guideline;

class GuidelineRepository extends Repository {
 
    public function model() {
        return 'App\Entities\Guideline';
    }

    
    public function firstOrCreate($user_id=null){
        if($user_id==null){
            $user_id = \Auth::id();
        }
        $guidelineInfor= Guideline::where('user_id',$user_id)->whereNotIn('status',array('version'))->first();
//        $guidelineInfor->update(['status'=>'version']);
        if(null==$guidelineInfor){
            $guidelineInfor =Guideline::create(array('user_id'=>$user_id,'status'=>'draft'));
        }
        return ($guidelineInfor);
    }
    
}