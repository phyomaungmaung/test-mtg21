<?php 
namespace App\Repositories;

use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;
use App\Entities\Result;

class ResultRepository extends Repository {

//https://laravel.io/index.php/forum/03-06-2014-getting-the-enum-possibilities-for-an-enum-field

    public function model() {
        return 'App\Entities\Result';
    }




    /*
     * start semi result
     */

    public function getSemiWiner(){

    }

    public function getSemiResultInCat( int $category_id){

    }



    /*
     * end semi result
     */

    /*
     * start final result
     */


    /*
     * end final result
     */

    /*
     * other
     */

    
}