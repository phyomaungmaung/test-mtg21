<?php

namespace App\Http\Controllers;

use App\Entities\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ApplicationRepository;
use App\Repositories\JudgeRepository;
use App\Repositories\FinalJudgeRepository;
use App\Repositories\ResultRepository;
use App\Entities\CategoryUser;
use App\Entities\Country as Country;
use Yajra\Datatables\Datatables;
use Auth;
use App\customVendors\setting\SettingFacade as Setting;

class FinalJudgeController extends Controller
{

    protected $redirectTo = '/finalapp';

    public function __construct(CategoryRepository $category,UserRepository $user,Country $country,ApplicationRepository $application,JudgeRepository $judge,FinalJudgeRepository $fjudge,ResultRepository $result)
    {
        // $this->started=Carbon::createFromFormat('m/d/Y H', \Setting::get('STARTED_JUDGEMENT_DATE').'0');

        $this->middleware('auth');
        $this->idTable = 1;
        $this->user=$user;
        $this->category=$category;
        $this->country=$country;
        $this->application=$application;
        $this->judge=$judge;
        $this->fjudge=$fjudge;
        $this->result=$result;
        $this->star=0;

    }

    public function finalApplication()
    {
        
        if(!\Setting::get("CAN_FINAL_JUDGE")&&!\Auth::user()->is_super_admin){
            $msg="Sorry! You cannot judge now. Please contact your administrator.";
            $type="red";
            return redirect('/')->with(["error"=>$msg]);
        }
        
        $rcate=$this->category->makeModel()->select("id","name")->orderBy("name")->pluck("name","id")->toArray();
        $rcate['all']="All Categories";
        asort($rcate);
        return view('finaljudge.judgebycate',compact('rcate'));
    }


    public function getFinalList(Request $request)
    {
        if(!\Setting::get("CAN_FINAL_JUDGE")&&!\Auth::user()->is_super_admin){
            $msg="Sorry! You cannot judge now. Please contact your administrator.";
            $type="red";
            return redirect('/')->with(["error"=>$msg]);
        }

        $auth=\Auth::user();
        $application=[];
        $judged_id=[];
        $judge_draft=null;
        if($auth->hasRole('Final Judge')){
            $this->arr_draft=$this->fjudge->makeModel()->where('user_id',$auth->id)->where('type','final')->select('app_id')->orderBy('num_star')->pluck('app_id')->toArray();
        }else{
            $this->arr_draft=$this->fjudge->makeModel()->where('type','final')->select('app_id')->pluck('app_id')->toArray();
        }
        
        if($auth->hasRole('Final Judge')){
            $pre_app=[];
            // $judge=$this->fjudge->makeModel()->where('user_id',$auth->id)->where('type','final')->orderBy('num_star')->get();
            $judge=$this->arr_draft;
            $user_app=$this->result->makeModel()->where("status","active")->get();
            foreach ($user_app as $value) {
                $pre_id=$value->user->application->id;
                // if(!in_array($pre_id,$judged_id))
                    $pre_app[]=$value->user->application;
            }
            // dd($user_app);
            $select_cat=$request->valcate;
            if(!isset($select_cat)){
                $select_cat='1';
            }
            $usercate=$this->user->find($auth->id)->categories;
            $cate_id=[];
            if(isset($usercate)){
                foreach ($usercate as $key => $value) {
                    $cate_id[]=$value->id;
                }
            }
            foreach ($pre_app as $key => $app) {
                    if(($app->user&&$app->user->categories[0]&&($app->user->categories[0]->id==$select_cat))||$select_cat=='all'){
                        $application[]=$app;
                    }
            }
        }else{
            $select_cat=$request->valcate;
            if(!isset($select_cat)){
                $select_cat='all';
            }
            $user_app=$this->result->makeModel()->where('type','semi')->where("status","active")->get();
            $pre_app=[];
            foreach ($user_app as $key=>$value) {
                if($value->user->categories[0]->id==$select_cat||strcasecmp($select_cat, 'all')==0){
                    $app_info=$value->user->application;
                    $pre_app[$key]=$app_info;
                    $getstar=$this->fjudge->makeModel()->where('app_id',$app_info->id)->where('type','final')->get();
                    $getgold=0;
                    $getsilver=0;
                    $getbrown=0;
                    foreach ($getstar as $value) {
                        if($value->num_star==3){
                            $getgold++;
                        }elseif($value->num_star==2){
                            $getsilver++;
                        }elseif($value->num_star==1){
                            $getbrown++;
                        }
                    }
                    $pre_app[$key]['gold']=$getgold;
                    $pre_app[$key]['silver']=$getsilver;
                    $pre_app[$key]['brown']=$getbrown;
                }
            }
            $application=$pre_app;
        }
        return Datatables::of($application)
            ->addColumn('id',function ($application){
                return $this->idTable++;
            })
            ->addColumn('product', function ($application) {
                return ucwords($application->product_name?$application->product_name:"");
            })
            ->addColumn('applicant', function ($application) {
                return ucwords($application->user->username?$application->user->username:"");
            })
            ->addColumn('star', function ($application) {
                $str="";
                if(!(\Auth::user()->is_super_admin||Auth::user()->hasRole('Admin'))){
                    $user_id=\Auth::id();
                    $cat_id=$application->user->categories[0]->id;
                    $app_id=$application->id;
                    $num_star=$this->fjudge->makeModel()->where('user_id',$user_id)->where('app_id',$app_id)->where('category_id',$cat_id)->where('type','final')->select('num_star')->first();
                    $star=$num_star['num_star'];
                    return $star;
                }else{
                    $url=3*(int)$application['gold']+2*(int)$application['silver']+(int)$application['brown']; 
                    return $url;
                }
                return $str;           
            })
            ->addColumn('medal', function ($application) {
                if(!(\Auth::user()->is_super_admin||\Auth::user()->hasRole('Admin'))){
                    $user_id=\Auth::id();
                    $cat_id=$application->user->categories[0]->id;
                    $app_id=$application->id;
                    // return $app_id;
                    $num_star=$this->fjudge->makeModel()->where('user_id',$user_id)->where('app_id',$app_id)->where('type','final')->where('category_id',$cat_id)->select('num_star')->first();
                    // return json_encode();
                    $star=$num_star['num_star'];
                    if($star==3)
                        $url[0]=[asset("images/img/mdgold.png"),1 ]; 
                    else if($star==2)
                        $url[1]=[asset("images/img/mdsilver.png"),1 ]; 
                    else if($star==1)
                        $url[3]=[asset("images/img/mdbrown.png"),1]; 
                    else
                        $url=["Not yet judge",0];
                    
                    return $url;
                    
                }else{
                    $url[0]=[asset("images/img/mdgold.png"),$application['gold'] ]; 
                    $url[1]=[asset("images/img/mdsilver.png"),$application['silver'] ]; 
                    $url[3]=[asset("images/img/mdbrown.png"),$application['brown'] ]; 
                    return $url;
                }
                return $str;
                
            })
            ->addColumn('country', function ($application) {
                $auth=\Auth::user();
                if($auth->is_super_admin||$auth->hasRole('Admin')){
                    return ucwords($application->user->country?$application->user->country->name:"");
                }
                return "";
            })
            ->addColumn('status',function($application){
                return ucwords($application->status);
            })
            ->addColumn('action', function ($application) {
                $result='';
                if(\Auth::user()->can('view-video')){
                    $result .= '<a href="'.route('video.player', $application->video()->id).
                        '" class="btn btn-icon btn-danger btn-xs m-b-3" title="Video" style="margin-right: 5px;"><i class="fa fa-youtube-play"></i></a>';
                }
                $result .= '<a href="'.route('application.aseanview', $application->id).
                    '" class="btn btn-icon btn-primary btn-xs m-b-3" title="Review" style="margin-right: 5px;"><i class="fa fa-list"></i></a>';
                if(Auth::user()->hasRole('Final Judge')){
                        $result .= '<a href="'.route('finaljudge.judged', $application->id).
                        '" class="btn btn-icon btn-success btn-xs m-b-3" title="Judge" style="margin-right: 5px;"><i class="fa fa-gavel"></i></a>';
                }
                return $result;
            })
            ->make(true);

    }

    public function judged($id){
        $auth=\Auth::user();
        $condition=true;
        if(!\Setting::get("CAN_FINAL_JUDGE")&&!\Auth::user()->is_super_admin){
            $msg="List of application form to be judged will be displayed later. <b>"."</b>";
            return redirect()->back()->with(['error'=>$msg]);
        }
        
        $app=$this->application->find($id);
        if(!$auth->hasRole('Final Judge')){
            if(!$auth->is_super_admin){
                $msg="Sorry, you have no permission!";
                return redirect()->route('finaljudge.finalapp')->with(['error'=>$msg]);
            }
        }else{
            $usercate=$auth->categories;
            $cate_id=[];
            if(isset($usercate)){
                foreach ($usercate as $key => $value) {
                    if($value->pivot->type=='final')
                        $cate_id[]=$value->id;
                }
            }
            if(!in_array($app->user->categories[0]->id, $cate_id)){
                $msg='Sorry, you have no permission!'; 
                return redirect()->route('finaljudge.finalapp')->with(['error'=>$msg]);
            }
        }
        
        $user=$this->user->find($app->user_id);
        $cate=$user->categories[0]->name;
        $user_id=\Auth::id();
        $form=$this->fjudge->makeModel()->where('app_id',$id)->where('user_id',$user_id)->where('type','final')->first();
    
        $my_apps=$this->result->makemodel()->where('status','active')->where('type','semi')->get();

        $all_app=[];
        $str_name=[];
        foreach ($my_apps as $value) {
            if($value->user->categories[0]->id==$user->categories[0]->id){
                $all_app[]=$value->user->application;
                $str_name[$value->user->application->id]=$value->user->application->product_name;
            }
        }

        $my_score=[];
        
        foreach($all_app as $value) {
            $tmp_judge=$this->fjudge->makeModel()->where("app_id",$value->id)->where("user_id",$user_id)->where("type",'final')->first();
            if(isset($tmp_judge))
            $my_score[$value->id]=$tmp_judge->total;
            else{
                $my_score[$value->id]=0;
            }
        }

        $dub_star=false;
        $star=[];
        $max_star=4;
        arsort($my_score);
        if(isset($my_score)){
            foreach ($my_score as $key=>$value) {
                if($value==0)
                    $star[$key]=0;
                else
                    $star[$key]=--$max_star;
            }
        }
        if($app){
            $title = $app->product_name;
            return view('finaljudge.judge')->with(compact('title','cate','form','id',"str_name","star","my_score"));
        }
         return redirect()->back();
        
    }

    public function saveScore(Request $request,$id)
    {
        $condition=true;
        if(!\Setting::get("CAN_FINAL_JUDGE")){
            $msg="You cannot display the list of application to judge Please contact your administrator.<b>"."</b>"; 
            return redirect()->back()->with(['error'=>$msg]);
        }

        /**
     * Run the migrations.
     * in is innovation
     * ps is problem solving
     * pv is public value
     * ti transparancy and iq
     * ef efficiency
     * pm performance
     * qt quality
     * rt reliability
     * op organization presentation
     * en enquiries
     * ms marketing strategy
     * cu customer
     * fi financial
     * ca competitive advantage
     * me market entry
     * sc scalability
     * tm team organization
     * sh stackholder
     * 
     */
        

        $arr=['in','ps','pv','ti','ef','pm','qt','rt','op','en','ms','cu','fi','ca','me','sc','tm','sh'];
        $data=$request->all();

        $data = array_map(function($value) {
            return $value == null ? 0 : $value;
        }, $data);

        foreach ($arr as $key => $value) {
            if(!array_key_exists($value, $data)){
                $data=$data+[$value=>0];
            }
        }
        
        $app=$this->application->find($id);
        $cate=$app->user->categories[0]->id;
        $cate_name=$app->user->categories[0]->name;
        $va=$this->validatorScore($data,$cate_name);
        
        if(!$app){
            $msg='Form Application does not found'; 
            return redirect()->back()->withInput()->with(['error'=>$msg]);
        }else if($va->fails()){
            $msg='Please check your given score. It must be between 1 and 10.'; 
            return redirect()->back()->withErrors($va)->withInput()->with(["error"=>$msg]);
        }else{

            $cate=$app->user->categories[0]->id;
            $user_id=\Auth::id();
            $form=$this->fjudge->makeModel()->where('app_id',$id)->where('user_id',$user_id)->where('type','final')->first();
    
            if(\Auth::user()->hasRole("Final Judge")){
                $condition=true;
            }else{
                $condition=false;
            }    
            if(!$condition){
                $msg="You cannot display the list of application to judge. Please contact your administrator.<b>"."</b>";
                return redirect()->back()->with(['error'=>$msg]);
            }

            $data['app_id']=$id;
            $data['category_id']=$cate;
            $data['user_id']=$user_id;
            // $data['type']='final';
            $cat_name=$app->user->categories[0]->name;
            $total=0;
            $data['status']=1;
            $data['type']='final';

            if(strcasecmp($cate_name,"Public Sector")==0){
                $strategy=(($data['in']/10)*20)+(($data['ps']/10)*25)+
                            (($data['pv']/10)*30)+(($data['ti']/10)*25);
                $sstrategy=($strategy/100)*40;

                $operation=(($data['ef']/10)*25)+(($data['pm']/10)*25)+
                            (($data['qt']/10)*25)+(($data['rt']/10)*25);
                $soperation=($operation/100)*40;

            }elseif(strcasecmp($cate_name,"Private Sector")==0||strcasecmp($cate_name,"Digital Content")==0){
                $strategy=(($data['in']/10)*30)+(($data['ps']/10)*20)+
                            (($data['ms']/10)*30)+(($data['cu']/10)*20);
                $sstrategy=($strategy/100)*40;

                $operation=(($data['ef']/10)*25)+(($data['pm']/10)*25)+
                            (($data['qt']/10)*25)+(($data['rt']/10)*25);
                $soperation=($operation/100)*40;
            }elseif(strcasecmp($cate_name,"Research and Development")==0){
                $strategy=(($data['in']/10)*25)+(($data['ps']/10)*25)+
                    (($data['ms']/10)*25)+(($data['cu']/10)*25);
                $sstrategy=($strategy/100)*40;

                $operation=(($data['ef']/10)*25)+(($data['pm']/10)*25)+
                    (($data['qt']/10)*25)+(($data['rt']/10)*25);
                $soperation=($operation/100)*40;
            }elseif(strcasecmp($cate_name,"Corporate Social Responsible")==0){
                $strategy=(($data['in']/10)*25)+(($data['ps']/10)*25)+
                            (($data['pv']/10)*25)+(($data['cu']/10)*25);
                $sstrategy=($strategy/100)*40;

                $operation=(($data['ef']/10)*25)+(($data['pm']/10)*25)+
                            (($data['qt']/10)*25)+(($data['rt']/10)*25);
                $soperation=($operation/100)*40;
            }elseif(strcasecmp($cate_name,"Start-up Company")==0){
                $strategy=(($data['ms']/10)*20)+(($data['fi']/10)*20)+
                            (($data['ca']/10)*20)+(($data['in']/10)*20)+
                            (($data['me']/10)*20);
                $sstrategy=($strategy/100)*40;

                $operation=(($data['sc']/10)*25)+(($data['tm']/10)*25)+
                            (($data['sh']/10)*25)+(($data['qt']/10)*25);
                $soperation=($operation/100)*40;
            }
            $presentation=(($data['op']/10)*50)+(($data['en']/10)*50);
            $spresentation=($presentation/100)*20;
            
            $total=$sstrategy+$soperation+$spresentation;

            $data['total']=$total;

            $user=$this->user->find($user_id);
            $my_apps=$this->result->makeModel()->where('type','semi')->where('status','active')->get();
            $all_app=[];
            foreach ($my_apps as $value) {
                if($value->user->categories[0]->id==$cate){
                    $all_app[]=$value->user->application;
                }
            }
            
            $my_score=[];
            foreach($all_app as $value) {
                $tmp_judge=$this->fjudge->makeModel()->where("app_id",$value->id)->where("user_id",$user_id)->where('type', 'final')->first();
                if($tmp_judge)
                $my_score[$value->id]=$tmp_judge->total;
                else{
                    $my_score[$value->id]=0;
                }
            }
            $my_score[$id]=$total;
            $dub_star=false;
            $star=[];
            $max_star=4;
            arsort($my_score);
            if(($my_score)){
                foreach ($my_score as $key=>$value) {
                    if($key!=$id){
                        if($value==$total){
                            $dub_star=true;
                        }
                    }
                    if($value==0)
                        $star[$key]=0;
                    else
                        $star[$key]=--$max_star;
                }
            }
            // $my_score=
            if($dub_star){
                $msg='You cannot provide the same score to the application in this category.'; 
                return redirect()->back()->withInput()->with(['error'=>$msg]);
            }
            $change_cate_num=$this->category->find($cate);  
            $cate_user=$user->categories;
            $numberform=0;
            $data['num_star']=$star[$id];
            foreach ($star as $key=>$value) {
                $update_star=$this->fjudge->makeModel()->where("app_id",$key)->where("user_id",$user_id)->where('type','final')->first();
                if($update_star){
                    $update_star->update(['num_star'=>$value]);
                }
            }
            if(isset($cate_user)){
                $numberform=$this->fjudge->makeModel()->where("category_id",$cate)->where("user_id",$user_id)->where('type','final')->count();
            }


            if(isset($form)>0){
                $sav=$form->update($data);
                CategoryUser::where('user_id',$user_id)->where('category_id',$cate)->where('type','final')->update(['num_form'=>$numberform]);

                if($sav){
                    $msg='Application Form has been saved successfully. '; 
                    return redirect()->route('finaljudge.finalapp')->with(["cate"=>$cate,'success'=>$msg]);
                }
            }else{

                $sav=$this->fjudge->create($data);
                if($sav){
                    
                    $numberform=$numberform+1;
                    $fcate=$this->category->find($cate);
                    CategoryUser::where('user_id',$user_id)->where('category_id',$cate)->where('type','final')->update(['num_form'=>$numberform]);
                    // $fcate->users()->updateExistingPivot($user_id,['num_form'=>$numberform],false);
                    
                    $msg='Application Form has been saved successfully. '; 

                    return redirect(route('finaljudge.finalapp'))->with(["cate"=>$cate,'success'=>$msg]);
                }else{
                    $msg='Some error occure during process.'; 
                    return redirect()->back()->withInput()->with(['error'=>$msg]);
                }
            }
        } 
        
    }

    protected function validatorScore(array $data,$cate)
    {
        // dd($data);
        $valdata=[];
        if(strcasecmp($cate,"Public Sector")==0){
            $valdata=[
                'in'=>'numeric|min:1|max:10',
                'ps'=>'numeric|min:1|max:10',
                'pv'=>'numeric|min:1|max:10',
                'ti'=>'numeric|min:1|max:10',
                'ef'=>'numeric|min:1|max:10',
                'pm'=>'numeric|min:1|max:10',
                'qt'=>'numeric|min:1|max:10',
                'rt'=>'numeric|min:1|max:10',
                'op'=>'numeric|min:1|max:10',
                'en'=>'numeric|min:1|max:10'
            ];
        }elseif(strcasecmp($cate,"Private Sector")==0||strcasecmp($cate,"Digital Content")==0||strcasecmp($cate,"Research and Development")==0){
            $valdata=[
                        'in'=>'numeric|min:1|max:10',
                        'ps'=>'numeric|min:1|max:10',
                        'ms'=>'numeric|min:1|max:10',
                        'cu'=>'numeric|min:1|max:10',
                        'ef'=>'numeric|min:1|max:10',
                        'pm'=>'numeric|min:1|max:10',
                        'qt'=>'numeric|min:1|max:10',
                        'rt'=>'numeric|min:1|max:10',
                        'op'=>'numeric|min:1|max:10',
                        'en'=>'numeric|min:1|max:10'
                    ];
        }elseif(strcasecmp($cate,"Corporate Social Responsible")==0){
            $valdata=[
                'in'=>'numeric|min:1|max:10',
                'ps'=>'numeric|min:1|max:10',
                'pv'=>'numeric|min:1|max:10',
                'cu'=>'numeric|min:1|max:10',
                'ef'=>'numeric|min:1|max:10',
                'pm'=>'numeric|min:1|max:10',
                'qt'=>'numeric|min:1|max:10',
                'rt'=>'numeric|min:1|max:10',
                'op'=>'numeric|min:1|max:10',
                'en'=>'numeric|min:1|max:10',
                ];
        }elseif(strcasecmp($cate,"Start-up Company")==0){
            $valdata=[
                'ms'=>'numeric|min:1|max:10',
                'fi'=>'numeric|min:1|max:10',
                'ca'=>'numeric|min:1|max:10',
                'in'=>'numeric|min:1|max:10',
                'me'=>'numeric|min:1|max:10',
                'sc'=>'numeric|min:1|max:10',
                'tm'=>'numeric|min:1|max:10',
                'sh'=>'numeric|min:1|max:10',
                'qt'=>'numeric|min:1|max:10',
                'op'=>'numeric|min:1|max:10',
                'en'=>'numeric|min:1|max:10'
            ];
        }
        return Validator::make($data,$valdata);
        
    }


    public function freez()
    {
        $allcate=$this->category->all();
        $arruser=[];
        $canFreezze = 1;
        foreach ($allcate as $cates) {
            $users=$cates->users;
            foreach ($users as $user) {
                if($user->pivot->type=="final"&&$user->pivot->num_form<3){
                    $arruser[$user->id][$cates->id]['name']=$user->username;
                    $arruser[$user->id][$cates->id]['country']=$user->country->name;
                    $arruser[$user->id][$cates->id]['category']=$cates->name;
                    $arruser[$user->id][$cates->id]['num_star']=3-$user->pivot->num_form;
                }
            }
        }
        if(count($arruser) >0 &&  \Setting::get("FREEZE_WITHOUT_CON", false) ){
            $canFreezze =0;
        }
        if( \Setting::get("CAN_FINAL_JUDGE",false) ==false){
            $canFreezze =2;
        }
        return view('finaljudge.freez',compact('arruser','canFreezze'));

    }
    public function dofreeze()
    {
        if(! \Setting::get('CAN_FINAL_JUDGE',true)){
            return redirect()->back()->with(['info'=>'Already Freeze !!!']);
        }
        $allcate=$this->category->all();
        $arruser=[];
        $canfreeze=true;
        $total=3;

        $mess =['Can not Freeze !!!', " Please ask the judge to complete the judgement !!!"];
        foreach ($allcate as $cate) {
            $users=$cate->users;
            $notCompleteJudges = CategoryUser::where('type','final')
                ->where('category_id',$cate->id)
                ->where('num_form','<',$total)
                ->get();
            if($notCompleteJudges && $notCompleteJudges->count()>0){
                $canfreeze=false;
                foreach ($notCompleteJudges as $notCompleteJudge){
                    $name = $notCompleteJudge->user->username;
                    $country = $notCompleteJudge->country->name;
                    $mess[]= "$name from $country remain ".($total- $notCompleteJudge->num_form)." application(s) in Category $cate->name !";

                }
            }
//            foreach ($users as $user) {
//                if($user->hasRole('Final Judge')&&$user->pivot->type=="final"&&$user->pivot->num_form<3){
//                    $canfreeze=false;
//                }
//            }
        }

        if($canfreeze ||  Setting::get("FREEZE_WITHOUT_CON", false)  ){
            Setting::set('CAN_FINAL_JUDGE',false,"BOOLEAN");
            return redirect(route('result.index'))->with(['info'=>'Freeze Success !!']);
        }else{

            return redirect()->back()->withErrors($mess);
        }



    }


}