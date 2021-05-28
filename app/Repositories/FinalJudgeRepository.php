<?php 
namespace App\Repositories;

use Bosnadev\Repositories\Contracts\RepositoryInterface;
use Bosnadev\Repositories\Eloquent\Repository;
use App\Entities\Application;
use FontLib\TrueType\Collection;
use Illuminate\Support\Facades\DB;
use Unisharp\Setting\Setting;

class FinalJudgeRepository extends Repository {

    public function model() {
        return 'App\Entities\Judge';
    }

    // final block
    public function findFinalWinerApp($limit=3){
        $win= collect();
        $cats = $this->category->makeModel()->get();
        $i=0;
        // this block will get collection which contain app_id and total star
        foreach ($cats as $cat){
            $user_ids = $this->__finalGudgeIdInCatNotComplete($cat->id);
            // avg
           $apps= \DB::table('final_judge')
                ->where('category_id',$cat->id)
//                ->where('type','final')
                ->whereNoIn('user_id',$user_ids)
//                ->select( \DB::raw(' sum(num_star) as stars') ,  'app_id')
                ->select( \DB::raw(' sum(num_star) as stars ,evg(total) as score ') ,  'app_id', 'category_id')
                ->groupBy('app_id')
                -> orderBy('stars','DESC')
                ->find();
            ;
            $win->push($apps);

        }
        // apps sort by number of star
        $winner = $win->sortByDesc('stars');

        return $this->__finalRankBaseOnStar($winner,0,$limit);

    }
    /*
    private function __finalRank($apps,$index,$num_douplicate){
        $numberWinder = $this->__findNumFormCanWinFianl();
        $all = array();
        $winner = $apps->sortByDesc('score');
        //return

    }*/

    private function __finalRankBaseOnStar($apps, $index=0,$num_win_more){
        $all = array();
        if($apps->count()>0){
            // get first element
            //$app = $allApp->shift();
            $app = $apps->first();
            $tmps = $apps->where('stars',$app);
            if(count($tmps)>1){
                // rand by criteria
                //@todo : update number win more
                array_merge($all,$this->__finalRankBaseOnTotalScore($tmps,$index,$num_win_more));
                $c = count($tmps);
                if( $c  < $num_win_more  ){
                    for($i=0;$i<$c;$i++){
                        $apps->shift();
                    }
                    $w =$this->__finalRankBaseOnStar($apps,$index+$c,$num_win_more-$c);
                    array_merge($all,$w);
                }

            }else{
                $all[$index++]= $app;
                $apps->shift();
                if($num_win_more>1){
                    $w =$this->__finalRankBaseOnStar($apps,$index,$num_win_more+1);
                    array_merge($all,$w);
                }
            }

        }
        return $all ;
    }

    /*
     * apps :  all app that douplicate
     *
     */

    private function __finalRankBaseOnTotalScore($apps,$index,$num_win_more=1){
        //$numberWinder = $this->__findNumFormCanWinFianl();
        /*
        $keys = $apps->keyBy('app_id');
        $app_ids = $keys->keys()->toArray();// array of app_id
        */
        $all = array();
        if($apps->count()>0){
            // get first element
            //$app = $allApp->shift();
            $app = $apps->first();
            $tmps = $apps->where('score',$app);
           // $numberWinder = $this->__findNumFormCanWinFianl();
            if(count($tmps)>1){
                // rand by criteria
                // @todo : param shoud be only app douplicate
                array_merge($all,$this->__finalRankBaseOnCriteria($tmps,$index,$num_win_more));
                $c =  count($tmps);
                if( $c  < $num_win_more  ){
                    for($i=0;$i<$c;$i++){
                        $apps->shift();
                    }
                    $w =$this->__finalRankBaseOnTotalScore($apps,$c+$index,$num_win_more-$c);
                    array_merge($all,$w);
                }
            }else{
                $all[$index++]= $app;
                $apps->shift();
                if($num_win_more>1){
                    $w =$this->__finalRankBaseOnStar($apps,$index,$num_win_more-1);
                    array_merge($all,$w);
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
            $tmp= \DB::table('final_judge')
                ->where('category_id',$app->category_id)
//                ->where('type','final')
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
                array_merge($tmps,$eqs);
                $eqs= array();
                array_push($tmps,$max);
                $max=$apps[$i];
            }
            if(count($eqs)>0){
                // @todo : compare level field;
                array_merge($win,$this->__finalRankBaseOnFields($eqs,$index,$num_win_more));
                if(count($eqs)<$num_win_more){
                    array_merge($win,$this->__finalRankBaseOnSubCriteria($tmps,$index+count($eqs),$num_win_more-count($eqs)) );
                }
            }else{
                $win[$index++] = $max;
                if($num_win_more>1){
                    array_merge($win,$this->__finalRankBaseOnSubCriteria($tmps,$index,$num_win_more-1));
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
        $cats = $this->category->makeModel()->get();
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
                array_merge($tmps,$eqs);
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
            array_merge($win,$mytmp);
// end
            if(count($eqs)<$num_win_more){
                array_merge($win,$this->__finalRankBaseOnFields($tmps,$index+count($eqs),$num_win_more-count($eqs)) );
            }
        }else{
            $win[$index++] = $max;
            if($num_win_more>1){
                array_merge($win,$this->__finalRankBaseOnFields($tmps,$index,$num_win_more-1));
            }
        }

    }
    /*
     *  $app a object app
     *  $sub_name : subcriteria name {stp, imp,pre}
     */
    private function __calSubCriteria($app,$sub_name){
        $score =0;
        $fields = $this->__getFieldCriteria();
        $cat = $this->category->makeModel()->get($app->category_id);
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

    private function __getFieldCriteria(){
        return [
            'Public Sector'=>[
                'stp'=>['in'=>25,'ps'=>25,'pv'=>25,'ti'=>25],
                'imp'=>['ef'=>25,'pm'=>25,'qt'=>25,'rt'=>25],
                'pre'=>['op'=>50,'en'=>50]
            ],
            'Corporate Social Responsible'=>[
                'stp'=>['in'=>25,'ps'=>25,'pv'=>25,'cu'=>25],
                'imp'=>['ef'=>25,'pm'=>25,'qt'=>25,'rt'=>25],
                'pre'=>['op'=>50,'en'=>50]
            ],
            'Start-up Company'=>[
                'stp'=>['ms'=>20,'fi'=>20,'ca'=>20,'in'=>20,'me'=>20],
                'imp'=>['sc'=>25,'tm'=>25,'sh'=>25,'qt'=>25],
                'pre'=>['op'=>50,'en'=>50]
            ],
            'Digital Content'=>[
                'stp'=>['in'=>30,'ms'=>30,'ps'=>20,'cu'=>20],
                'imp'=>['ef'=>25,'pm'=>25,'qt'=>25,'rt'=>25],
                'pre'=>['op'=>50,'en'=>50]
            ],
            'Private Sector'=>[
                'stp'=>['in'=>30,'ms'=>30,'ps'=>20,'cu'=>20],
                'imp'=>['ef'=>25,'pm'=>25,'qt'=>25,'rt'=>25],
                'pre'=>['op'=>50,'en'=>50]
            ],
            'Research and Development'=>[
                'stp'=>['in'=>30,'ms'=>30,'ps'=>20,'cu'=>20],
                'imp'=>['ef'=>25,'pm'=>25,'qt'=>25,'rt'=>25],
                'pre'=>['op'=>50,'en'=>50]
            ],

        ];
    }

/*
 * convert from collection apps to app which app is an average
 * $apps : collections of app which app_id is the same
 */
    private function __getEvg($apps){
        $fields = ['in','ps','pv','ti','ef','pm','qt','rt','op','en','cu','ms','ca','fi','me','sc','tm','sh','total'];
        $tmp = null;
        $count = $apps->count();
        if($count>0){
            $tmp=$apps->shift();
            foreach ($apps as $key => $app){
                foreach ($fields as $field){
                    $tmp[$field]+=$app[$field];
                    // last element of array apps
                    if($key==$count-2){
                        // find evg
                        $tmp[$field] = $tmp[$field]/$count;
                    }
                }
            }

        }
        return $tmp;
    }

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
    private function __finalGudgeIdInCatNotComplete($cat_id,$nFormInCat=3){
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
    private function __findFormWinSemiInCat($cat_id){
        return \Setting::get('NUM_FORM_WIN_SEMI_IN_CAT',3);

    }

    private function __findNumFormCanWinFianl($cat_id){
        return \Setting::get('NUM_FORM_WIN_FINAL',3);

    }


    
}