<?php

namespace App\Exports;

use App\Entities\Application;
use App\Entities\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\JudgeRepository;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SemiResultsDetailExport implements WithMultipleSheets
{
    private $judgeCountryNames=[];
    public function __construct(CategoryRepository $category, JudgeRepository $judge)
    {
        $this->category= $category;
        $this->judge = $judge;
    }

    private function __myPrepareData(Collection $apps, Category $category,$fields){
        $rows =collect();
        foreach ($apps as $app){
            if(!isset($app['application'])){
                $app['application'] = Application::find($app['app_id']);
            }
            $row=[];

            $row['product_name']= $app['application']->user->username;
//            $row['company_name']= $app['application']['company_name'];
            $row['country']= $app['application']->user->country->name;
//            dd($app);
            $row['score']= isset($app['score'])?$app['score']:$app['total'];
            $rows->add($row);
            $judges =$this->judge->makeModel()->where('type','semi')->where('category_id',$category->id)
                ->where('app_id',$app['app_id'])->orderBy('user_id')->get();
            foreach ($judges as $judge){
                $r =[];
                $r['username']= $judge->user->username;
                $r['country']= $judge->user->country->name;
                $r['score']= number_format($judge['total'],3);
                foreach ($fields as $f){
                    $r[$f]= $judge->{$f};
                }
                $rows->add($r);
            }
            $rows->push([' ']);
        }
        return $rows;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $categories = $this->category->all();
        $judgeCountries =$this->judge->getSemiFinalJudgeCountries();
        $this->judgeCountryNames= $judgeCountries->pluck('name')->toArray();


        foreach ($categories as $category) {
            $tmp = $this->judge->findSemiWinerAppInCat($category,18);


            $fields = $this->judge->getAttributeByCategory($category);
            $datas = $this->__myPrepareData($tmp,$category,$fields);
            $sheets[] = new SemiResultDetailByCategoryExport($category,$datas,$fields);
        }
        return $sheets;
    }
}
