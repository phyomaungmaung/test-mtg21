<?php 
namespace App\Repositories;

use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;
use App\Entities\FormSubmission;

class FormSubmissionRepository extends Repository {

//https://laravel.io/index.php/forum/03-06-2014-getting-the-enum-possibilities-for-an-enum-field

    public function model() {
        return 'App\Entities\FormSubmission';
    }

    public function test(){
        return "vitou";
    }
    public function firstOrCreate($user_id=null){
        if($user_id==null){
            $user_id = \Auth::id();
        }
        $applicationInfor= FormSubmission::where('user_id',$user_id)->whereNotIn('status',array('version'))->first();
        if(null==$applicationInfor){
            $applicationInfor =FormSubmission::create(array('user_id'=>$user_id,'status'=>'draft'));
        }
        return ($applicationInfor);
    }
    
}