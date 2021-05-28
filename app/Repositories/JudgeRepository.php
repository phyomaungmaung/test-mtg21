<?php
namespace App\Repositories;

use App\Entities\Application;
use App\Entities\Category;
use App\Entities\CategoryUser;
use App\Entities\Country;
use App\Entities\FinalJudge;
use App\Entities\Result;
use App\Entities\User;
use Bosnadev\Repositories\Eloquent\Repository;
use App\Entities\Judge;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class JudgeRepository extends Repository {



    /* public function __construct(Judge $model,CategoryRepository $category)
     {
         $this->category = $category;
 //        $this->model = $model;
         $this->makeModel();
     }*/

    public function model() {
        return 'App\Entities\Judge';
    }

    /*
     * start semi final
     */

    /**
     * @param $cat_id
     * @param int $limit
     * @return Collection
     */
    public function findSemiWinerAppInCat(Category $category,$limit=3):Collection{
        $num_app_in_cat = $this->__getNumberAppInCat($category->id);
        $judgs = $this->__getJudgeIdNotCompleteInCatOfSemi($category->id, $num_app_in_cat);
        $apps =$this->model->where('type','semi')
            ->where('category_id',$category->id)
//            ->where('status',1)
            ->whereNotIn('user_id',$judgs)
            ->wherehas("application",function ( $query) {
                $query->where('id', '!=', null);
            })
            ->select( \DB::raw(' avg(total) as score '),'app_id')
            ->groupBy('app_id')
            -> orderBy('score','DESC')
            ->get()->toArray();


        return $this->__getSemiWinerAppInCat($apps,$category,1,$limit);
    }

    /**
     * @param array $apps
     * @param Category $cat
     * @param int $start_rank
     * @param int $limit
     * @return Collection
     */
    private function __getSemiWinerAppInCat(array $apps,Category $cat,$start_rank=1,$limit=3):Collection{
        $win= collect();
        $c = count($apps);
        $is_equal =false;
        $equal_at=0;
        $n = $limit;
//        for($i=$start;($i<$limit&&$i<$c-1 && !$is_equal);$i++ ){
//        $i=$start_rank-1;
        $i = 0;
        for(;($i<$c-1 && $win->count() < $n && !$is_equal);$i++ ){
            if( $apps[$i+1]['score']==$apps[$i]['score'] ){
                $is_equal=true;
                $equal_at=$i;
            }else{
                $apps[$i]['order']=$start_rank++;
                $win=$win->push($apps[$i]);
                unset($apps[$i]);
            }
        }
        if(!$is_equal){
            // the last index
            if($win->count()< $n && isset($apps[$i]['app_id'])){
                $apps[$i]['order']=$start_rank++;
                $win=$win->push($apps[$i]);
                unset($apps[$i]);
            }
        }else{
            //        2 or more app equal score
            $number_equal=1;
            $app_ids = [];// app_id that equal
            array_push($app_ids,$apps[$equal_at]['app_id']);
            $tmp= $apps[$equal_at];
            unset($apps[$equal_at]);
            // check number app have equal score
            for($i=$equal_at;$i<$c-1 && $tmp['score']==$apps[$i+1]['score'] ;$i++){
                $number_equal++;
                array_push($app_ids, $apps[$i+1]['app_id']);
                unset($apps[$i+1]);
            }
            $remain_winer = $n - $win->count();

            if($remain_winer>0){
                $applications = $this->__calculateEVGOfGuiteria($app_ids,$cat,'semi')->toArray();
                $l = count($applications);
                $l= $l<$remain_winer?$l:$remain_winer;
                $more_win = $this->__getRankByCriteria($applications,$cat,$start_rank,$l);
                $win=$win->merge($more_win);
                $remain_winer-=$l;
                $start_rank+=$l;
            }

            if($remain_winer>0){
                $apps=collect($apps)->values()->toArray();// reindex array from 0;
                $l = count($apps);
                $l= $l<$remain_winer?$l:$remain_winer;
                $additional_winner = $this->__getSemiWinerAppInCat($apps,$cat,$start_rank,$l);
                $win= $win->merge($additional_winner);
            }
        }
        return $win;
    }

    /**
     * find list user_id of judged that not complete in category
     * @param $cat_id
     * @param $nFormInCat
     * @return array of user_id
     */
    public function __getJudgeIdNotCompleteInCatOfSemi($cat_id, $nFormInCat){
        return CategoryUser::where('category_id',$cat_id)->where('type','semi')
            ->where('num_form','<',$nFormInCat)->pluck('user_id')->all();
    }

    /**
     * count all app in a category
     * @param $cat_id
     * @return integer
     */
    public function __getNumberAppInCat($cat_id):int{

        $n = Application::whereIn('status',['accepted'/*,'comment'*/]) ->whereHas('user', function($u) use ($cat_id){
            $u->whereHas('roles',function ($r){
                $r->where('name','Candidate');
            })
                ->whereHas('candidateCategories',function ($c) use ($cat_id){
                    $c->where('id',$cat_id);
                })
            ;})->count();

        return $n;
//        return \DB::table('users')
//            ->join('applications','users.id','=','applications.user_id')
//            ->where('applications.status','accepted')
//            ->where('users.category_id',$cat_id)
//            ->count();
    }

    /**
     * using in new code
     * @param array $apps
     * @param Category $category
     * @param int $start_rank
     * @param int $limit
     * @param string $type
     * @return Collection
     */
    private function __getRankByCriteria(array $apps,Category $category,$start_rank=0,$limit=3,$type='semi'):Collection{
//        $applications = $this->__calculateEVGOfGuiteria($application_ids,$category,$type);
        $applications= collect($apps);
        // $apps=$applications->toArray();
        $ctrs = config("scoring.".$category->abbreviation);

        $fieds= $this->getAttributeByCategory($category,true);
        $winner = collect();
        $c = $applications->count(); // $apps is a sorting collections
        $is_equal=false;
        $equal_at = 0;
        $n = $limit;
        $i=0;
        for(;$i<$c-1 && $winner->count()<$n &&!$is_equal;$i++){
            if(isset($apps[$i][$ctrs[0]['name']])){
                if( ($apps[$i][$ctrs[0]['name']]+ $apps[$i][$ctrs[1]['name']]) == ($apps[$i+1][$ctrs[0]['name']]+ $apps[$i+1][$ctrs[1]['name']])){
                    $is_equal=true;
                    $equal_at=$i;
                }else{
                    $apps[$i]['order']=$start_rank++;
                    $apps[$i]['ByCriteria']=1;
                    $winner=$winner->push($apps[$i]);
                    unset($apps[$i]);
                }
            }else{
                $r = $this.$this->__compareByAttr($apps[$i],$apps[$i+1],$category);
                if($r==0){
                    $is_equal = true;
                    $equal_at= $i;
                }else if($r>0){
                    $apps[$i]['order']=$start_rank++;
                    $apps[$i]['ByCriteria']=1;
                    $winner=$winner->push($apps[$i]);
                    unset($apps[$i]);

                }else{
                    $tmp= $apps[$i+1];
                    $apps[$i+1]= $apps[$i];
                    $tmp['order']=$start_rank++;
                    $tmp['ByCriteria']=1;
                    $winner=$winner->push($tmp);
                    unset($apps[$i]);
                }

            }
        }

        if(!$is_equal){
            // handle last index
            if($winner->count()<$n){
                $apps[$i]['order']=$start_rank++;
                $apps[$i]['ByCriteria_more']=1;
                $winner=$winner->push($apps[$i]);
                unset($apps[$i]);
            }
        }else {
            //        2 or more app equal score
            $number_equal = 1;
            $equalIds = [];// app_id that equal
            array_push($equalIds,$apps[$equal_at]['app_id']);
            // check number app have equal score
            $tmp = $apps[$equal_at];
            unset($apps[$equal_at]);
            for ($i = $equal_at; $i < $c - 1 ; $i++) {

                if(isset($tmp[$ctrs[0]['name']])){
                    if( ($tmp[$ctrs[0]['name']]+ $tmp[$ctrs[1]['name']]) ==
                        ($apps[$i+1][$ctrs[0]['name']]+ $apps[$i+1][$ctrs[1]['name']])) {
                        $number_equal++;
                        array_push($equalIds, $apps[$i + 1]['app_id']);
                        unset($apps[$i+1]);
                    }
                }else{
                    if($this.$this->__compareByAttr($tmp,$apps[$i+1]) == 0){
                        $number_equal++;
                        array_push($equalIds, $apps[$i + 1]['app_id']);
                        unset($apps[$i+1]);
                    }
                }
            }
            $remain_winner = $n - $winner->count();
            // get only equal
            $eg_applications= $applications->whereIn('app_id',$equalIds)->values()->toArray();
            if($remain_winner>0){
                $l = count($eg_applications);
                $l = $l<$remain_winner?$l:$remain_winner;
                $more_win = $this->__getRankByAttribute($eg_applications,$category,$start_rank,$l);
                $winner= $winner->merge($more_win);
                $remain_winner-=$more_win->count();
                $start_rank+=$more_win->count();
            }
            if ($remain_winner >0) {
                $apps=collect($apps)->values()->toArray(); // re-index array from 0
                $l = count($apps);
                $l = $l<$remain_winner?$l:$remain_winner;
                $additional_winner = $this->__getRankByCriteria($apps, $category, $start_rank, $l);
                $winner=$winner->merge($additional_winner);
            }
        }
        return $winner;
    }

    /**
     * @param $app1
     * @param $app2
     * @param Category|null $category
     * @return int  0 eq, >0 app1 > app2, and <0 app1 < app2
     */

    private function __compareByAttr($app1, $app2,Category $category = null):int {
        $fieds= $this->getAttributeByCategory($category,true);
        $n = count($fieds);
        for($i=0;$i<$n;$i++){
            if($app1[$fieds[$i]] != $app2[$fieds[$i]]){
                return $app1[$fieds[$i]] - $app2[$fieds[$i]];
            }
        }

        return 0;
    }

    /**
     * @param Collection $apps
     * @param Category $category
     * @param $start_rank
     * @param $limit
     * @return Collection
     */
    private function __getRankByAttribute(array $apps,Category $category,$start_rank, $limit):Collection{
        $fieds = config("scoring.".$category->abbreviation);
        $att1 = Arr::get($fieds,'0.items',[]);
        $att2 = $fieds[1]['items'];
        $att3 = collect(Arr::get($fieds,'2.items',[]))->map(function ($value,$key){
            return $value/=2;
        });
        $attibutes=collect($att1)->merge($att2)->merge($att3)->toArray();
        uasort($attibutes,function ($a,$b){return $b-$a;});

        $c = count($apps);
        $winner= collect();
        $already = [];
        $n= $limit;

        for($i=0;$i<$c && $n>$winner->count();$i++){
            $k=0; // winner
            while (in_array($k,$already))$k++;
            $eqs = [];
            for($j=$k+1;$j<$c;$j++){
                if(in_array($j,$already)){
                    continue;
                }
//                $tmp1 = $apps[$j];
                $eq_all= true;
                foreach ($attibutes as $attibute=>$v){
                    if($apps[$k][$attibute] ==$apps[$j][$attibute] ){
                        continue;
                    }
                    $eq_all=false;
                    if($apps[$k][$attibute] < $apps[$j][$attibute]){
                        $eqs=[];
                        $k = $j;
                    }
                    break 1;// exit foreach
                }
                if($eq_all){
                    array_push($eqs,$j);
                }

            }// end loop $j
            array_push($already,$k);
            $apps[$k]['byAttr']=1;
            $apps[$k]['order'] =$start_rank;
            $winner=$winner->push($apps[$k]);

            foreach ($eqs as $e_i){
                array_push($already,$e_i);
                $apps[$e_i]['byAttr_eq']=1;
                $apps[$e_i]['order'] = $start_rank;
                $winner=$winner->push($apps[$e_i]);
            }
            $start_rank+=count($eqs);
            $start_rank++;
        }
        // case the last elements
        for($i=0;$i<$c && $n>$winner->count();$i++){
            if(!in_array($i,$already)){
                $apps[$i]['byAttr']=1;
                $apps[$i]['order'] =$start_rank++;
                $winner=$winner->push($apps[$i]);
            }
        }

        return $winner;
    }

    /**
     * @param array $app_ids
     * @param Category $category
     * @param string $type
     * @return Collection : items of applications
     */
    private function __calculateEVGOfGuiteria(array $app_ids,Category $category, $type='semi'):Collection{
        $apps = [];
//        @todo: should check $type semi or final
        $num_app_in_cat = $this->__getNumberAppInCat($category->id);
        $id_judge_not_completes = $this->__getJudgeIdNotCompleteInCatOfSemi($category->id,$num_app_in_cat );
        $fieds = config("scoring.".$category->abbreviation);
        // find evg for all app
        foreach ($app_ids as $app_id){
            $tmps = $this->makeModel()->where('type',$type)
//                ->where('status',2)@todo : what does status do?
//                    ->where('category_id',$category->id)

//                ->wherehas("application",function ( $query) {
//                    $query->where('id', '!=', null);
//                })
                ->whereNotIn('user_id',$id_judge_not_completes)
                ->where('app_id',$app_id)
                ->get();
            $n =count($tmps);
            if($n<1){continue;}
            $app=null;
            foreach ($tmps as $tmp){
                if(null == $app){
                    $app=$tmp;
                }else{
                    foreach ($fieds as $fied){
                        foreach ($fied['items'] as $key=> $item){
                            $app[$key]+=$tmp[$key];
                        }
                    }
                    $app['total']+=$tmp['total'];
                }
            }
            $app['order']=0;
            // get avg
            $guteria = 0;
            foreach ($fieds as $index=> $fied){
                $app[$fied['name']]=0;
                foreach ($fied['items'] as $key=> $weight){
                    $app[$key]/=$n;
                    $app[$fied['name']]+=($app[$key]/10*$weight);
                }
                $app[$fied['name']]=($app[$fied['name']]/100*$fied['weight']);
                $guteria+=$app[$fied['name']];// @todo: check
            }
            $app['total']/=$n;
            $apps[]=$app->toArray();

        }

        uasort($apps,function ($a,$b)use ($fieds){
            return ($b[$fieds[0]['name']] + $b[$fieds[1]['name']] )-($a[$fieds[0]['name']] + $a[$fieds[1]['name']]);
        });
        // end find evg
        return collect($apps)->values();
    }

    /*
     * end semi final
     */
    /*
     * start final
     */

    /**
     * @param Category $category
     * @return int : number semi app for final judge
     */
    private function __getNumberWinneSemiAppInCat(Category $category){
        return Result::where('category_id',$category->id)->where('type','semi')->count();
    }

    private function __getIdJudgeNotCompleteFinalInCat(Category $category,$total_app_in_cat){
        return CategoryUser::where('category_id',$category->id)->where('type','final')
            ->where('num_form','<',$total_app_in_cat)->pluck('user_id')->all();
    }

    public function findFinalWinerApp(Category $category,$limit=null){
        $type = 'final'; // @todo: change final after judging complete
        // this block will get collection which contain app_id and total star
        if(!$limit){
            $limit  = $this->__getNumberWinneSemiAppInCat($category);
        }
        $judge_not_complete_ids = $this->__getIdJudgeNotCompleteFinalInCat($category,$limit);
        // avg
        $apps= $this->model
            ->where('category_id',$category->id)
            ->where('type',$type)
            ->wherehas("application",function ( $query) {
                $query->where('id', '!=', null);
            })
//            ->whereNotIn('user_id',$judge_not_complete_ids)// @todo : uncomment here
//                ->select( \DB::raw(' sum(num_star) as stars') ,  'app_id')
            ->select( \DB::raw(' sum(num_star) as stars ,avg(total) as score ') ,  'app_id', 'category_id')
            ->groupBy('app_id')
            -> orderBy('stars','DESC')
            ->get();
        // apps sort by number of star

        $winner = $apps->sortByDesc('score')->values();
//        @todo: check sort
        $tmp=  $this->__finalRankBaseOnStar($winner,0,$limit);
        return $tmp;
    }


    private function __finalRankBaseOnStar($apps, $rank=0,$num_win_more){
        $all = collect();
        if($apps->count()>0){
            $app = $apps->first();
            if($apps->where('stars','>',$app->stars)->count()>0){
                $apps=$apps->sortByDesc('stars');
            }
            $tmps = $apps->where('stars',$app->stars);
            if( $tmps->count()>1){
                // rand by criteria
                //@todo : update number win more
                $all=$all->merge( $this->__finalRankBaseOnTotalScore($tmps,$rank,$num_win_more));
                $c = $tmps->count();
                if( $c  < $num_win_more  && $c < $apps->count() ){
                    $app_ids=$tmps->pluck('app_id');
                    $apps= $apps->whereNotIn('app_id',$app_ids);
                    $w =$this->__finalRankBaseOnStar($apps,$rank+$c,$num_win_more-$c);
                    $all=$all->merge($w);
                }
            }else{
                $app->rank=++$rank;
                $all = $all->add($app);
                $apps->shift(); // remove first element
                if($num_win_more>1){
                    $w =$this->__finalRankBaseOnStar($apps,$rank,$num_win_more-1);
                    $all=$all->merge($w);
                }
            }
        }
        return $all ;
    }

    /*
     * old code
     */

    // final block

    /*
     * apps :  all app that douplicate
     *
     */

    private function __finalRankBaseOnTotalScore(Collection $apps,$index,$num_win_more=1){

        $all = collect();
        $apps=$apps->sortByDesc('score');
        if($apps->count()>0){
            // get first element
            $app = $apps->first();
            $tmps = $apps->where('score',$app->score);
            // $numberWinder = $this->__findNumFormCanWinFianl();
            if($tmps->count()>1){
                // rand by criteria
                // @todo : param shoud be only app douplicate
                $all=$all->merge( $this->__finalRankBaseOnCriteria($tmps,$index,$num_win_more));
                $c =  count($tmps);
                if( $c  < $num_win_more  ){
                    for($i=0;$i<$c;$i++){
                        $apps->shift();
                    }
                    $w =$this->__finalRankBaseOnTotalScore($apps,$c+$index,$num_win_more-$c);
                    $all=$all->merge($w);
                }
            }else{
                $all[$index++]= $app;
                $apps->shift();
                if($num_win_more>1){
                    $w =$this->__finalRankBaseOnStar($apps,$index,$num_win_more-1);
                    $all=$all->merge($w);
                }
            }

        }
        return $all ;

    }
    /*
     * $apps : collect of app that douplicate
     * return array ass which $key as rank
     */
    private function __finalRankBaseOnCriteria($apps,$index,$num_win_more){

        $app_id_keys = $apps->keyBy('app_id');
        $app_ids = $app_id_keys->keys()->toArray();// array of app_id
        $cat_ids = $apps->keyBy('category_id')->keys();
        $allApps = array();

        foreach ($apps as $app){
            $total_form_to_judge = __findFormWinSemiInCat($app->actegory_id);
            $j_ids = __finalGudgeIdInCatNotComplete($cat_ids,$total_form_to_judge);
            $tmp= \DB::table('judges')
                ->where('category_id',$app->category_id)
                ->where('type','final')
                ->where('status',1)
                ->whereIn('app_id',$app->app_id)
                ->whereNoIn('user_id',$j_ids)
                ->find();
            $r = $this->__getEvg($tmp);
            if(null != $r){
                $r['stp']= $this->__calSubCriteria($r,'stp');
                $r['imp']= $this->__calSubCriteria($r,'imp');
                $r['pre']= $this->__calSubCriteria($r,'pre');
                array_push($allApps,$r);
            }

        }
        return $this->__finalRankBaseOnSubCriteria($allApps,$index,$num_win_more);
    }

    private function __finalRankBaseOnSubCriteria($apps,$index,$num_win_more){
        $count = count($apps);
        $win = array();
        if($count>0){
            $tmps= array();
            $eqs = array();
            $max = $apps[0];
            for($i=1;$i<$count;$i++){
                if($apps[$i]['stp']<$max['stp']) {
                    array_push($tmps, $apps[$i]);
                    countinue;
                }else  if($apps[$i]['stp']==$max['stp']){
                    if($apps[$i]['imp']<$max['imp']){
                        array_push($tmps, $apps[$i]);
                        countinue;
                    }else if($apps[$i]['imp']==$max['imp']){
                        if($apps[$i]['pre']<$max['pre']) {
                            array_push($tmps, $apps[$i]);
                            countinue;
                        }else if($apps[$i]['pre']==$max['pre']) {
                            array_push($eqs, $apps[$i]);
                            countinue;
                        }
                    }
                }
                $tmps=array_merge($tmps,$eqs);
                $eqs= array();
                array_push($tmps,$max);
                $max=$apps[$i];
            }
            if(count($eqs)>0){
                // @todo : compare level field;
                $win= array_merge($win,$this->__finalRankBaseOnFields($eqs,$index,$num_win_more));
                if(count($eqs)<$num_win_more){
                    $win= array_merge($win,$this->__finalRankBaseOnSubCriteria($tmps,$index+count($eqs),$num_win_more-count($eqs)) );
                }
            }else{
                $win[$index++] = $max;
                if($num_win_more>1){
                    $win= array_merge($win,$this->__finalRankBaseOnSubCriteria($tmps,$index,$num_win_more-1));
                }
            }
        }
        return $win;
    }
    private function __finalRankBaseOnFields($apps,$index,$num_win_more){
        $count = count($apps);
        if($count<1){
            return [];
        }
        $win = array();
        $fieldCat = $this->__getFieldCriteria();
        $tmps= array();
        $eqs = array();
        $max = $apps[0];
//        $cats = $this->category->makeModel()->get();
        $cats = Category::all();
        $cat_list = $cats->pluck('id', 'name')->all();
//        @todo : test cat_list;
        $max_fields = $fieldCat[$cat_list[$max->category_id]->name];
        for($i=1;$i<$count;$i++){
            $current_fields = $fieldCat[$cat_list[$apps[$i]->category_id]->name];
            $bigger = true;
            $is_eq= true;

            foreach ($current_fields as $sub=>$fs){
                $c1=count($fs);
                $c2 = count($max_fields[$sub]);
                $c= ($c2>$c1)?$c1:$c2;
                $mfs=array_values($max_fields[$sub]);
                $cfs=array_values($fs);
                for($m=0;$m<$c && $bigger==true;$m++){
                    if($max[$mfs[$m]]<$apps[$cfs[$m]]){
                        $bigger=false;
                        $is_eq=false;
                    }else if($max[$mfs[$m]]>$apps[$cfs[$m]]){
                        $is_eq=false;
                    }
                }
            }
            if($bigger==false){
                $tmps=array_merge($tmps,$eqs);
                $eqs= array();
                array_push($tmps,$max);
                $max=$apps[$i];
            }else if($is_eq==true){
                array_push($eqs, $apps[$i]);
            }
        }
        if(count($eqs)>0){
            // @todo : if it equal event Field level ;
            $m_index = $index;
            //array_merge($win,$this->__finalRankBaseOnFiels($eqs,$index,$num_win_more));// this func schoud change
//            @todo: just temperary solotion need to update more if it is equal all
            $mytmp =array();
            for($ii=0;$ii<count($eqs)&& $ii<$num_win_more;$ii++){
                $mytmp[$m_index++] =$eqs[$ii];
            }
            $win=array_merge($win,$mytmp);
// end
            if(count($eqs)<$num_win_more){
                $win=array_merge($win,$this->__finalRankBaseOnFields($tmps,$index+count($eqs),$num_win_more-count($eqs)) );
            }
        }else{
            $win[$index++] = $max;
            if($num_win_more>1){
                $win=array_merge($win,$this->__finalRankBaseOnFields($tmps,$index,$num_win_more-1));
            }
        }
        return $win;

    }
    /*
     *  $app a object app
     *  $sub_name : subcriteria name {stp, imp,pre}
     */
    private function __calSubCriteria($app,$sub_name){
        $score =0;
        $fields = $this->__getFieldCriteria();
//        $cat = $this->category->makeModel()->get($app->category_id);

        $cat = Category::find($app->category_id);
        foreach ($fields as $cat_name=>$sub_criterias){
            if(strcasecmp($cat->name,$cat_name)==0){
                foreach ($sub_criterias as $sub_cri=>$fs){
                    if(strcasecmp($sub_cri,$sub_name)==0){
                        $sc= 0;
                        foreach ($fs as $f=>$percentage){
                            $sc = $sc + ($app[$f]*$percentage /100);
                        }
                        if(strcasecmp($sub_cri,'pre')==0){
                            $score= $sc*20/100;
                        }
                    }
                }
            }
        }
        return $score;
    }

//__getFieldCriteria
//__getEvg



    /*
     * all judge in a category
     */

    private function __findFinalJudgeInCat($cat_id){
        /*return array_values( \DB::table('category_user')
            ->where('category_id',$cat_id)
            ->where('type','final')
           // ->where('num_form','<',$nFormInCat)
            ->pluck('user_id')->toArray()
        );*/
        return  \DB::table('category_user')
            ->where('category_id',$cat_id)
            ->where('type','final')
            ->find();


    }


    /*
     *  return array of judge id who not judge all app in a category
     */
    public function __finalJudgeIdInCatNotComplete($cat_id, $nFormInCat=3){
        return array_values( \DB::table('category_user')
            ->where('category_id',$cat_id)
            ->where('type','final')
            ->where('num_form','<',$nFormInCat)
            ->pluck('user_id')->toArray()
        );

    }


    /*
     * return number application form that can win in a category
     */
    public function __findFormWinSemiInCat($cat_id){
        return \Setting::get('NUM_FORM_WIN_SEMI_IN_CAT',3);

    }


    /*
     * $app_id application id
     * $type : type medal { 1: brown, 2: silver, 3: gold}
     */

    private function __getNumMedalAppByType($app_id,$type,$complete){
        return Judge::where('type','final')-> where('app_id',$app_id)->whereIn('user_id',$complete)->where('num_star',$type)->count();
    }
    /*
     *  $total : number from tobe Judge
     *  return array of Id of judge who not yet finish Judge
     */

    public function finalJudgeNotCompleteIds($total=18){
        $tmp= User::has('finalJudges','<',$total)->orderBy('id')->get();
        return array_values( $tmp->pluck('id')->toArray() );

    }

    /*
     *  $total : number from tobe Judge
     *  return array of Id of judge who  finish Judge
     */
    public function finalJudgeCompleteIds($total=18){
        $tmp= User::has('finalJudges','>=',$total)->orderBy('id')->get();
        return array_values( $tmp->pluck('id')->toArray() );

    }

    public function finalCompleteJudgeIdsByCat($cat_id,$total=0){

//        $tmp = CategoryUser::where('type','final')
//            ->where('category_id',$cat_id)
//            ->where('num_form',$total)
//            ->get();

        $tmp= $this->model->where('type','final')
            ->where('category_id',$cat_id)
            ->groupBy('user_id')
            ->selectRaw(' count(user_id) as total  ,  user_id')
            ->having('total','=',$total)
            ->get();
        return array_values( $tmp->pluck('user_id')->toArray() );
    }
    /*
     * return number that win semi final and available for final judge
     */

    public function numFinalFormTobeJudge(){
        return Result::where('type','semi')->where('status','active')->count('user_id');
    }

    /**
     * Realtime final result
     * @return array
     */

    public function getFinalResult(){
        $wins= collect();
        $categories = Category::all();
        foreach ($categories as $category){
            $tmp= $this->getFinalResultInCategory($category);
            if($tmp && $tmp->count()>0){
                $wins=$wins->merge($tmp);
            }
        }
        return $wins;
    }

    public function getFinalResultInCategory(Category $category){
        $num_app_in_cat = 3;
        $complete_judge_ids= $this->finalCompleteJudgeIdsByCat($category->id,$num_app_in_cat);
        $apps= $this->model->where('type','final')
            ->where('category_id',$category->id)
            ->whereIn('user_id',$complete_judge_ids)
//                ->select( 'app_id', \DB::raw(' sum(num_star) as stars ,avg(total) as score '),'category_id' )
            ->groupBy('app_id')
            ->selectRaw('app_id, category_id, sum(num_star) as stars ,avg(total) as score ')
            -> orderBy('stars','DESC')
            ->get();

        $tmp = collect();

        foreach ($apps as $app){
            $app->gold= $this->__getNumMedalAppByType($app->app_id,3,$complete_judge_ids);
            $app->silver = $this->__getNumMedalAppByType($app->app_id,2,$complete_judge_ids);
            $app->brown= $this->__getNumMedalAppByType($app->app_id,1,$complete_judge_ids);
            $app->medals=[$app->gold,$app->silver,$app->brown];
            $app->users = $this->model->where('type','final')->where('app_id',$app->app_id) ->where('category_id',$category->id)
                ->whereIn('user_id',$complete_judge_ids)  -> orderBy('user_id','DESC')  ->get()
//                    ->pluck('num_star','country.name');
                ->map(function ($item){
                    $tmp =$item->num_star;
                    $cname= $item->user->country->name;

                    return [$cname=>$tmp];
                })->collapse()->toArray();
            $app->application = Application::with('user', 'user.country', 'user.application')
                ->where('id', $app->app_id)->first();

            $tmp->push($app);
        }

        $tmp=$this->rankByTotalMedal($tmp->sortByDesc('stars'),$category,1,$num_app_in_cat);

        return $tmp;
    }

    /**
     * @param Collection $apps
     * @param Category $category
     * @param int $rank : start from 1
     * @param int $num_app
     * @return Collection
     */
    public function rankByTotalMedal(Collection $apps, Category $category,  $rank=1, $num_app=3){
        $all = collect();
        if($apps->count()>0){
            $app = $apps->first();
            if($apps->where('stars','>',$app->stars)->count()>0){ // if not sort by start
                $apps=$apps->sortByDesc('stars');
                $app = $apps->first();
            }
            $tmps = $apps->where('stars',$app->stars);
            if($tmps && count($tmps)>1){
                $golds = $tmps->sortByDesc('gold');
                $all=$all->merge( $this->rankBaseOnGold($golds,$category,$rank,$num_app));
                $c = $tmps->count();
                if( $c  < $num_app  ){
                    $app_ids = $tmps->pluck('app_id');
                    $apps = $apps->whereNotIn('app_id',$app_ids);
                    $w =$this->rankByTotalMedal($apps,$category,$rank+$c,$num_app-$c);
                    $all=$all->merge($w);
                }
            }else{
                $app->rank = $rank++;
                $all->push($app);
                $apps->shift();
                if($num_app>1){
                    $w =$this->rankByTotalMedal($apps,$category,$rank,$num_app-1);
                    $all=$all->merge($w);
                }
            }
        }

        return $all ;
    }

    /**
     * @param Collection $apps
     * @param Category $category
     * @param int $rank : start from 1
     * @param $num_app
     * @return Collection
     */
    public function rankBaseOnGold(Collection $apps, Category $category, $rank=1,$num_app){
        $all = collect();
        if($apps->count()>0){
            $app = $apps->first();
            if($apps->where('gold','>',$app->gold)->count()>0){ // not sort by gold
                $apps=$apps->sortByDesc('gold');
                $app = $apps->first();
            }
            $tmps = $apps->where('gold',$app->gold);
            if($tmps && $tmps->count()>1){
                $silvers = $tmps->sortByDesc('silver');
                $all=$all->merge( $this->rankBaseOnSilver($silvers,$category,$rank,$num_app));
                $c = count($tmps);
                if( $c  < $num_app  ){
                    $app_ids = $tmps->pluck('app_id');
                    $apps = $apps->whereNotIn('app_id',$app_ids);
                    $w =$this->rankBaseOnGold($apps,$category,$rank+$c,$num_app-$c);
                    $all=$all->merge($w);
                }
            }else{
                $app->rank = $rank++;
//                $all[$index++]= $app;
                $all->push($app);
                $apps->shift();
                if($num_app>1){
                    $w =$this->rankBaseOnGold($apps,$category,$rank,$num_app-1);
                    $all=$all->merge($w);
                }
            }
        }
        return $all ;

    }

    /**
     * @param Collection $apps
     * @param Category $category
     * @param int $rank : start from 1
     * @param $num_app
     * @return Collection
     */
    public function rankBaseOnSilver(Collection $apps, Category $category, $rank=1,$num_app){
        $all = collect();
        if($apps->count()>0){
            $app = $apps->first();
            if($apps->where('silver','>',$app->gold)->count()>0){
                $apps=$apps->sortByDesc('silver');
                $app = $apps->first();
            }
            $tmps = $apps->where('silver',$app->silver);
            $c = $tmps->count();
            if($c>1){
                $scores = $tmps->sortByDesc('score');
                // why not find by brown?
                $all=$all->merge($this->rankBaseAvgScore($scores,$category,$rank,$num_app));
                if( $c  < $num_app  ){
                    $app_ids = $tmps->pluck('app_id');
                    $apps = $apps->whereNotIn('app_id',$app_ids);
                    $w =$this->rankBaseOnSilver($apps,$category,$rank+$c,$num_app-$c);
                    $all=$all->merge($w);
                }
            }else{
                $app->rank = $rank++;
//                $all[$index++]= $app;
                $all->push($app);
                $apps->shift();
                if($num_app>1){
                    $w =$this->rankBaseOnSilver($apps,$category,$rank,$num_app-1);
                    $all=$all->merge($w);

                }
            }
        }
        return $all ;

    }

    /** use final
     * @param Collection $apps
     * @param Category $category
     * @param int $rank
     * @param $num_app
     * @return Collection
     */
    public function rankBaseAvgScore(Collection $apps, Category $category, $rank=1,$num_app){
        $all = collect();
        if($apps->count()>0){
            $app = $apps->first();
            if($apps->where('score','>',$app->score)->count()>0){
                $apps=$apps->sortByDesc('score');
                $app = $apps->first();
            }
            $tmps = $apps->where('score',$app->score);
            $c = $tmps->count();
            if($c>1){
                $app_ids = $tmps->pluck('app_id');
                $applications = $this->__calculateEVGOfGuiteria($app_ids->toArray(),$category,'final')->toArray();
                $byCri = $this->__getRankByCriteria($applications,$category,$rank,$num_app,'final');
                foreach ($byCri as $a){
                    $tmp = $tmps->where('app_id',$a['app_id'])->first();
                    $tmp->order = $a['order'];
                    $tmp->rank = $a['order'];
                    $all->push($tmp);
                }
//                $all=$all->merge($byCri);
                if( $c < $num_app  ){
                    $apps = $apps->whereNotIn('app_id',$app_ids);
                    $w =$this->rankBaseAvgScore($apps,$category,$rank+$c,$num_app-$c);
                    $all=$all->merge($w);
                }
            }else{
                $app->rank = $rank++;
                $all->push($app);
                $apps->shift();
                if($num_app>1){
                    $w =$this->rankBaseAvgScore($apps,$category,$rank,$num_app-1);
                    $all=$all->merge($w);
                }
            }
        }
        return $all ;
    }

// new code
    public function getFinalJudgeCountries(){
        $countries = Country::all();
        $industries= $countries->whereIn('name',array_values(\Settings::get('industries',[])))->sortBy('name')->values();
        $countries=  $countries->whereNotIn('name',array_values(\Settings::get('industries',[])))->sortBy('name')->values();
        $judge_countries = $countries->merge($industries);
        return $judge_countries;
    }

    public function getSemiFinalJudgeCountries(){
        $countries = Country::all();
        $countries=  $countries->whereNotIn('name',array_values(\Settings::get('industries',[])))->sortBy('name')->values();
        return $countries;
    }

    public function getAttributeByCategory(Category $category,$sort_by_wieght=false):array {
        $fieds = config("scoring.".$category->abbreviation);
        $fields = [];
        for($i=0;$i<3;$i++){
            if($i==2 && $sort_by_wieght){
                arsort($fields);
            }
            $att1 = Arr::get($fieds,"$i.items",[]);
            $fields= array_merge($fields,$att1);
//            $fields= array_merge($fields,array_keys($att1));
        }
        $fields = array_keys($fields);
        return $fields;
    }

}