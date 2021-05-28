<?php

namespace App\Exports;

use App\Entities\Application;
use App\Entities\Category;
use App\Entities\Result;
use App\Entities\User;
use App\Repositories\CategoryRepository;
use App\Repositories\JudgeRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FinalResultsDetailExport implements WithMultipleSheets
{
    private $judgeCountryNames=[];
    public function __construct(CategoryRepository $category, JudgeRepository $judge)
    {
        $this->category= $category;
        $this->judge = $judge;
    }



    private function __myPrepareData(Collection $apps, Category $category,$fields){


        $medals = [1=>'G',2=>'S',3=>'B'];
        $rows =collect();
        foreach ($apps as $app){
            $row=[];
//            $row['product_name']= $app['application']['product_name'];
            $row['product_name']= $app['application']->user->username;
            $row['company_name']= $app['application']['company_name'];
            $row['country']= $app['application']->user->country->name;
//            $row['start']='';
            $row['total_medal']="G:".$app['medals'][0]."\nS:".$app['medals'][1]."\nB:".$app['medals'][2];
            $rows->add($row);
            $judges =$this->judge->makeModel()->where('type','final')->where('category_id',$category->id)
                ->where('app_id',$app['app_id'])->orderBy('user_id')->get();
//            dd($app);
            foreach ($judges as $judge){
                $r =[];
                $r['username']= $judge->user->username;
                $r['country']= $judge->user->country->name;
                $r['score']= number_format($judge['total'],3);
//                $r['stars']=$judge['stars'];
                $t = 4-$judge['num_star'];
                $r['medal']= $medals[$t];
                foreach ($fields as $f){
                    $r[$f]= $judge->{$f};
                }

                $rows->add($r);
            }
            $rows->push([' ']);


        }
        return $rows;
/*

            return $out;
        });
//        foreach ($apps as $app){
//            $tmp = [];
//            $tmp = ['Product_name'];
//            $output->push($app);
//        }
//        return $output;
        return $apps;
        // */
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $categories = $this->category->all();
//        $ranks = $this->judge->getFinalResult();
//        $jNotCompleteIds = $this->judge->finalJudgeNotCompleteIds();
        // try{
        $judgeCountries =$this->judge->getFinalJudgeCountries();
        $judgeCountriesNameShort = $judgeCountries->pluck('bref')->toArray();
        $this->judgeCountryNames= $judgeCountries->pluck('name')->toArray();

        foreach ($categories as $category) {
            $tmp = $this->judge->getFinalResultInCategory($category);
            $fields = $this->judge->getAttributeByCategory($category);
//            $datas=$tmp;
            $datas = $this->__myPrepareData($tmp,$category,$fields);
//            dd($datas,$tmp);
            $sheets[] = new FinalResultDetailByCategoryExport($category,$datas,$fields);
        }
        return $sheets;
    }


}
