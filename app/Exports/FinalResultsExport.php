<?php

namespace App\Exports;

use App\Entities\Application;
use App\Entities\Result;
use App\Entities\User;
use App\Repositories\CategoryRepository;
use App\Repositories\JudgeRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FinalResultsExport implements WithMultipleSheets
{
    private $judgeCountryNames=[];
    public function __construct(CategoryRepository $category, JudgeRepository $judge)
    {
        $this->category= $category;
        $this->judge = $judge;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Result::all();
    }

    private function __myPrepareData(Collection $apps, $is_detail= false){
        $output = collect();
        $fields = [''];
        $medals = [1=>'G',2=>'S',3=>'B'];
        $apps =$apps->map(function ($item,$key) use ($medals){
            $item= $item->toArray();

            $out =[];
            $out['company_name']= $item['application']['company_name'];
            $out['product_name']= $item['application']['product_name'];
            try{
                $out['company_name']= $item['application']->user->username;
                $out['country']= $item['application']->user->country->name;
            }catch (\Exception $e){

                $out['country'] ="Cambodia";
            }
//            $out=array_merge($out,collect($item['users'])->map(function ($i) use($medals){
//                return $medals[4-$i];
//            })->toArray());
            $tmps=  $item['users'];
            foreach ($this->judgeCountryNames as $c_name){
                $score = Arr::get($tmps,$c_name,0);
                $out[$c_name]= Arr::get($medals,4-$score,"");
            }

//            dd($out);
            $out['total_medal']="G:".$item['medals'][0]."\nS:".$item['medals'][1]."\nB:".$item['medals'][2];
            $out['score_medal']= $item['stars'];
            $out['score']= number_format($item['score'],3);
            $out['win']= $medals[$item['rank']];

            return $out;
        });
//        foreach ($apps as $app){
//            $tmp = [];
//            $tmp = ['Product_name'];
//            $output->push($app);
//        }
//        return $output;
        return $apps;
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
            $datas = $this->__myPrepareData($tmp);

            $sheets[] = new FinalResultByCategoryExport($category,$datas,$judgeCountriesNameShort);
            /*
                     $medalTypes = ['1' => "G", "2" => "S", "3" => "B"];
                     $mTypes = ['G' => "Gold", "S" => "Silver", "B" => "Brown"];
                     $total_form = $this->judge->__findFormWinSemiInCat($category->id);
                     $completeJudgeIds = $this->judge->finalCompleteJudgeIdsByCat($category->id,$total_form);
                     $wins = collect();
                     $judgeCompletes = User::whereIn('id', $completeJudgeIds)->whereNotIn('id',$jNotCompleteIds)->get();
                     $judgeNotCompletes = User::whereHas('categories', function ($query) use ($judgeCompletes) {
                         $query->where('type', 'final')->whereNotIn('user_id', array_values($judgeCompletes->pluck('id')->toArray()));
                     })->get();
                     $head = ['Company Name', 'Product name', 'Country'];

                     if(strcasecmp( \Setting::get("SHOW_NOT_COMPLETE","FALSE"),"TRUE")==0 ){
                         $judgeCompletes=$judgeCompletes->merge($judgeNotCompletes)->sortBy('id');
                         $completeJudgeIds = array_values($judgeCompletes->pluck('id')->toArray());

                     }
                     foreach ($judgeCompletes as $jc) {
     //                        array_push($head, $jc->username);
                         array_push($head, $jc->country->name);
                     }
                     /*foreach ($judgeNotCompletes as $jc) {
                         array_push($head, $jc->username);
                     }*/

        }
        return $sheets;
    }


}
