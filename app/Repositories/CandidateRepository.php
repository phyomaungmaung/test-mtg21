<?php 
namespace App\Repositories;

use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CandidateRepository extends Repository {

    public function model() {
        return 'App\Entities\User';
    }
    
    public function detectNumber($id_cate,$id_coun){
        $user = $this->model->where('category_id', '=',$id_cate)->where('country_id','=',$id_coun)->count();
        return $user;
    }
}