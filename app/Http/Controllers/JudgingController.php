<?php

namespace App\Http\Controllers;

use App\Entities\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Forms\JudgeForm;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Input;
use App\Repositories\UserRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ApplicationRepository;
use App\Repositories\JudgeRepository;
use Yajra\Datatables\Facades\Datatables;
use App\Entities\Country as Country;
use Carbon\Carbon;
use App\Entities\CategoryUser;

class JudgingController extends Controller
{

    use RegistersUsers;

    protected $redirectTo = '/judging';

    public function __construct(CategoryRepository $category,UserRepository $user,Country $country,ApplicationRepository $application,JudgeRepository $judge)
    {
        $this->started=Carbon::createFromFormat('m/d/Y H', \Setting::get('STARTED_JUDGEMENT_DATE').'0');

        $this->middleware('auth');
        $this->idTable = 1;
        $this->user=$user;
        $this->category=$category;
        $this->country=$country;
        $this->application=$application;
        $this->judge=$judge;

    }
    public function showRegistrationForm(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(JudgeForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  route('judge.store'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'novalidate'=>  'novalidate'
            ]
        );
        
        $country=$this->country->select('name','id')->get();
        $category=$this->category->makeModel()->select('name','id')->orderBy('name')->get();
        $type=['Judge'=>'Online Judging','Final Judge'=>'Final Judging'];
        $arrco=[''=>'Select Country'];
        $arrcontry=config("industry");
        if(sizeof($country)>0){
            foreach ($country as $key => $value) {
                if(!in_array($value->name, $arrcontry))
                $arrco[$value->id]=$value->name;
            }
        }
        $arrcate=[];
        if(sizeof($category)>0){
            foreach ($category as $key => $value) {
                $arrcate[$value->id]=$value->name;
            }
        }

        // $users=$this->user->find(61);
        // $users->categories()->sync([]);
        // $users->categories()->attach(3,['num_form'=>'1','country_id'=>'2']);
        // return($users->categories[0]->id);
        // $ca=$this->category->find(2);
        // $users->categories()->sync(['2',['num_form'=>'0','country_id'=>'2'] ]);
        // $users->categories()->detach([1,2,3]);
        
        return view('judge.create',compact('arrco','arrcate','form','type'));
    }
    public function listcountry(Request $request){
        $country=$this->country->select('name','id')->get();
        $arrcontry=config("industry");
        $utype=$request->input('utype');
        $arrco[]=[];
        if(sizeof($country)>0){
            if($utype=='Judge'){
                foreach($country as $key => $value) {
                    if(!in_array($value->name,$arrcontry)){
                        $arrco[]=['id'=>$value->id,'text'=>$value->name];
                    }
                }
            }elseif($utype=="Final Judge"){
                foreach($country as $key => $value) {
                    $arrco[]=['id'=>$value->id,'text'=>$value->name];
                }
            }
        }
        return json_encode($arrco);
    }

    public function listuser($id){
        $user = $this->user->makeModel()->where('is_super_admin','!=','1')->where('parent_id','=',null)->where('country_id',$id)->orderBy('username', 'asc')->get();
        $userlist[]=[];
        if(sizeof($user)>0)
            foreach ($user as $key => $value) {
                $userlist[]=['id'=>$value->id,"text"=>$value->email];
            }
        return json_encode($userlist);
    }

    public function listcate(Request $request,$id){
        $user = $this->user->find($id);
        $type=$request->input('utype');
        if($type=='Judge'){
            $type='semi';
        }else if($type=='Final Judge'){
            $type='final';
        }
        $catlist=[];
        // $catlist['utype']=$user->categories[0]->pivot->type;
        if(sizeof($user)>0)
            $cats=$user->categories;
            foreach ($cats as $key => $cat) {
                if($cat->pivot->type==$type){
                    $catlist[]=$cat->id;
                }
            }
        return json_encode($catlist);
    }
    
    
    public function saveExisted(Request $request){

        $coun = $request->get("id_country");
        $indust=config("industry");
        $getCount=$this->country->find($coun);
        $getType=$request->get('id_type');
        $user= $request->get("id_user");
        $cate=$request->get("id_cate");
        $valid=$this->validate($request, [
                'id_country' => 'required',
                'id_user' => 'required',
                'id_cate' => 'required',
            ]);
        $check_coun=true;
        $err_form=true;
        $list_cat="";
        if(!$valid){
            if($getType=="Judge"&&!in_array($getCount,$indust)) {
                foreach ($cate as $key => $value) {
                    $cat=$this->category->find($value);
                    $cat_user=$cat->users;
                    foreach ($cat_user as $key => $cat_use) {
                        if($coun==$cat_use->pivot->country_id&&$cat_use->pivot->type=='semi'&&$user!=$cat_use->pivot->user_id){
                            $check_coun=false;
                            $list_cat.=$cat->name.', ';
                        }
                    }
                }
                if(!$check_coun){
                    flash()->error(lang('general.validate_jude_for_country',['cat'=>trim($list_cat,', ')])); 
                    if(sizeof($cate)>0){
                        $err_cate=array_values($cate);
                    }else{
                        $err_cate=[];
                    }
                    return redirect()->back()->withInput()->with(['err_form'=>$err_form,'err_cate'=>json_encode($err_cate)]);
                }else{
                    $existed_user=$this->user->find($user);
                    if(!$existed_user->hasRole('Judge')){
                        $existed_user->assignRole(['Judge']);
                    }
                    $arr=[];
                    foreach ($cate as $key => $value) {
                        if(!in_array($value,$existed_user->onlineCategories->pluck('id')->all())){
                            $arr=['country_id'=>$coun,'type'=>'semi'];
                            $existed_user->onlineCategories()->attach([$value=>$arr]);
                        }
                    }

                    if(isset($existed_user->onlineCategories)){
                        foreach ($existed_user->onlineCategories as $valcate) {
                            if(!in_array($valcate->id, $cate)){
                                CategoryUser::where('category_id',$valcate->id)->where('user_id',$existed_user->id)->where('type','semi')->delete();
                            }
                        }
                    }
                    // $existed_user->categories()->sync($arr);
                    flash()->info(lang('The record was saved.')); 
                    return redirect(route('judge.create'));
                }
            }
            if($getType=="Final Judge") {
                $existed_user=$this->user->find($user);
                if(!$existed_user->hasRole('Final Judge')){
                    $existed_user->assignRole(['Final Judge']);
                }

                foreach ($cate as $key => $value) {
                    $cat=$this->category->find($value);
                    $cat_user=$cat->users;
                    foreach ($cat_user as $key => $cat_use) {
                        if($coun==$cat_use->pivot->country_id&&$cat_use->pivot->type=='final'&&$user!=$cat_use->pivot->user_id){
                            $check_coun=false;
                            $list_cat.=$cat->name.', ';
                        }
                    }
                }
                if(!$check_coun){
                    flash()->error(lang('general.validate_jude_for_country',['cat'=>trim($list_cat,', ')])); 
                    if(sizeof($cate)>0){
                        $err_cate=array_values($cate);
                    }else{
                        $err_cate=[];
                    }
                    return redirect()->back()->withInput()->with(['err_form'=>$err_form,'err_cate'=>json_encode($err_cate)]);
                }else{
                    $existed_user=$this->user->find($user);
                    if(!$existed_user->hasRole('Final Judge')){
                        $existed_user->assignRole(['Final Judge']);
                    }
                    $arr=[];
                    
                    foreach($cate as $key => $value) {
                        if(!in_array($value,$existed_user->finalCategories->pluck('id')->all())){
                            $arr=['country_id'=>$coun,'type'=>'final'];
                            $existed_user->finalCategories()->attach([$value=>$arr]);
                        }
                    }
                    
                    if(isset($existed_user->finalCategories)){
                        foreach ($existed_user->finalCategories as $valcate) {
                            if(!in_array($valcate->id, $cate)){
                                CategoryUser::where('category_id',$valcate->id)->where('user_id',$existed_user->id)->where('type','final')->delete();
                            }
                        }
                    }
                    
                   // $existed_user->finalCategories()->sync($arr);
                    flash()->info(lang('The record was saved.')); 
                    return redirect(route('judge.create'));
                }
            }
            
        }
    }

    public function register(Request $request)
    {

        $this->validator($request->all())->validate();
        $valid=true;
        $indust=config("industry");
        // $getCount=$this->country->find($coun);
        $getType=$request->get('type');
        $list_cat="";
        $coun=$request->get('country_id');
        $cate=$request->get('category_id');
        if($getType=="Judge"){
            if(in_array($coun, [1,2,3,4,5,6,7,8,9,10])){
                foreach ($cate as $key => $value) {
                    $cat=$this->category->find($value);
                    $cat_user=$cat->users;
                    foreach ($cat_user as $key => $cat_use) {
                        if($coun==$cat_use->pivot->country_id&&$cat_use->pivot->type=='semi'){
                            $valid=false;
                            $list_cat.=$cat->name.', ';
                        }
                    }
                }
            }
            if($valid){
                $user=$this->create($request->all());
                $user->assignRole('Judge');
                event(new Registered($user));
                $arr=[];
                foreach ($cate as $key => $value) {
                    $arr[$value]=['num_form'=>'0','country_id'=>$request->get('country_id'),'type'=>'semi'];
                }
                $user->categories()->sync($arr);
                flash()->info(lang('The record was saved.')); 
                return redirect(route('judge.create'));
            }else{
                return redirect()->back()->withInput()->withErrors(["err_valid"=>lang('general.validate_jude_for_country',['cat'=>trim($list_cat,', ')])]);
            }
        }elseif($getType=="Final Judge"){
            foreach ($cate as $key => $value) {
                $cat=$this->category->find($value);
                $cat_user=$cat->users;
                foreach ($cat_user as $key => $cat_use) {
                    if($coun==$cat_use->pivot->country_id&&$cat_use->pivot->type=='final'){
                        $valid=false;
                        $list_cat.=$cat->name.', ';
                    }
                }
            }
            if($valid){
                $user=$this->create($request->all());
                $user->assignRole('Final Judge');
                event(new Registered($user));
                $arr=[];
                foreach ($cate as $key => $value) {
                    $arr[$value]=['num_form'=>'0','country_id'=>$request->get('country_id'),'type'=>'final'];
                }
                $user->categories()->sync($arr);
                flash()->info(lang('The record was saved.')); 
                return redirect(route('judge.create'));
            }else{
                return redirect()->back()->withInput()->withErrors(["err_valid"=>lang('general.validate_jude_for_country',['cat'=>trim($list_cat,', ')])]);
            }
        }
        
    }
 
    public function lists(){ 
        return view('judge.index');
    }
    public function getList(){
        $auth=\Auth::user();
        $user = $this->user->makeModel()->where('parent_id','=',null)->where('is_super_admin','!=','1');
        if($auth->is_super_admin||$auth->hasRole('Admin')){
            $user=$user->orderBy('username', 'asc')->get();
        }elseif ($auth->hasRole("Representer")) 
        {
            $user = $user->where('country_id',$auth->country_id)->orderBy('username', 'asc')->get();
        }
        $judge=[];
        if(isset($user)){
            foreach ($user as $key => $value) {
                if($value->hasRole('Judge')){
                    $judge[]=$value;
                }
            }
        }
        $judge_cate=[];
        foreach ($judge as $key => $value) {
            $cate_jud=$value->categories;
            $pays=$this->country->find($value->country_id);
            if(sizeof($cate_jud)>0){
                foreach ($cate_jud as $cat_key => $cat_val) {
                    $cat=$this->category->find($cat_val->pivot->category_id);
                    $numApp = $this->application->getNnumberAppInCat($cat->id);
//                    $draft=$this->judge->makeModel()->where("user_id",$value->id)->where('category_id',$cat->id)->where('status','1')->count();
                    $draft=$numApp - $cat_val->pivot->num_form;
                    $judge_cate[]=["name"=>$value->username,"email"=>$value->email,"category"=>$cat->name,"country"=>$pays->name,"numForm"=>$cat_val->pivot->num_form,'draft'=>$draft];
                }
                
            }
        }
        return Datatables::of($judge_cate)
            ->addColumn('id',function ($user){
                    return $this->idTable++;
                })
            ->addColumn('name', function ($user) {
                    return ucwords($user['name']);
                })
            ->addColumn('email', function ($user) {
                    return ucwords($user['email']);
                })
            ->addColumn('country',function($user){
                $auth=\Auth::user();
                if($auth->is_super_admin||$auth->hasRole('Admin')){
                    return ucwords($user['country']);
                }
                return null;
            })
            ->addColumn('category', function ($user) {
                    return ucwords($user['category']);
                })
            ->addColumn('Form', function ($user) {
                    $result = "";
                    $result .= '<div '.
                        '" class="btn btn-icon btn-danger btn-xs m-b-3" title="Draft Judged" style="margin-right: 5px;"><i class="">'.$user['draft'].'</i></div>';
                    $result .= '<div '.
                        '" class="btn btn-icon btn-success btn-xs m-b-3" title="Complete Judged" style="margin-right: 5px;"><i class="">'.$user['numForm'].'</i></div>';
                    return $result;
                })
            ->rawColumns(['Form'])
            ->make(true);
    }

    public function player($id){
        $auth=\Auth::user();
        $condition=true;
        if(Carbon::now()->lt($this->started)){
            $msg="List of application form to be judged will be displayed on : <b>".$this->started->toFormattedDateString()."</b>";
            $type="red";
            return view('layouts.message',compact('msg','type'));
        }
        $end_judge=Carbon::createFromFormat('m/d/Y H', \Setting::get('ENDED_JUDGEMENT_DATE').'0');
        $comp_date_judge=Carbon::createFromFormat('m/d/Y H', \Setting::get('ENDED_JUDGEMENT_DATE').'0');
        
        if(Carbon::now()->gt($comp_date_judge->addDay())){
            $condition=false;  
        }
        
        $app=$this->application->find($id);

        if(!$auth->hasRole('Judge')){
            if(!$auth->is_super_admin){
                flash()->error(lang('Sorry, you have no permission!')); 
                return redirect(route('application.aseanapp'));
            }
        }else{
            $usercate=$auth->categories;
            $cate_id=[];
            if(isset($usercate)){
                foreach ($usercate as $key => $value) {
                    $cate_id[]=$value->id;
                }
            }
            if(!in_array($app->user->category->id, $cate_id)){
                flash()->error(lang('Sorry, you have no permission!')); 
                return redirect(route('application.aseanapp'));
            }
        }
        
        $user=$this->user->find($app->user_id);
        $cate=$user->category->name;
        $user_id=\Auth::id();
        $form=$this->judge->makeModel()->where('app_id',$id)->where('user_id',$user_id)->first();
        
        if(Carbon::now()->gt($comp_date_judge)) 
        {
            if(\Setting::get('ALLOW_JUDGE_DRAFT','false')=='true'){
                if(sizeof($form)>0&&$form->status==1){
                $condition=true;
                }else{
                    $condition=false;
                }    
            }

            if(\Setting::get('ALLOW_JUDGE_ID',-1)==$auth->id){   
                $condition=true; 
            }


        }
        if(!$condition){
            if(\Setting::get('ALLOW_JUDGE_DRAFT')){
                $msg="We are sorry, the online judging is closed due to the deadline since : <b>".$end_judge->toFormattedDateString()."</b> We allowed only for draft judging.";
            }

             $msg="We are sorry, the online judging is closed due to the deadline since : <b>".$end_judge->toFormattedDateString()."</b>";
            $type="red";
            return view('layouts.message',compact('msg','type'));
        }
        if($app){
            $video = $app->youtube_id;
            $mime = "";
            $title = $app->product_name;
            $is_youtube=true;
            if(null == $app->youtube_id || $app->youtube_id ==""  ){
                $video = $app->video_demo;
                $is_youtube=false;
            }
            return view('judge.judge')->with(compact('video', 'mime', 'title','cate','form','id','is_youtube'));
        }
         return redirect()->back();
        
    }

    public function saveScore(Request $request,$id)
    {
        $condition=true;
        if(Carbon::now()->lt($this->started)){
            $msg="List of application form to be judged will be displayed on : <b>".$this->started->toFormattedDateString()."</b>";
            $type="red";
            return view('layouts.message',compact('msg','type'));
        }
        // $end_judge=Carbon::createFromFormat('m/d/Y H', \Setting::get('ENDED_JUDGEMENT_DATE').'0');
        
        // if(Carbon::now()->gt($end_judge->addDay())){
        //     $msg="We are sorry, the online judging is closed due to the deadline since : <b>".$end_judge->toFormattedDateString()."</b>";
        //     $type="red";
        //     return view('layouts.message',compact('msg','type'));
        // }
        
        $end_judge=Carbon::createFromFormat('m/d/Y H', \Setting::get('ENDED_JUDGEMENT_DATE').'0');
        $end_date_judge=Carbon::createFromFormat('m/d/Y H', \Setting::get('ENDED_JUDGEMENT_DATE').'0');
        
        if(Carbon::now()->gt($end_date_judge->addDay())){
            $condition=false;  
        }
        
        // in_array("Irix", $os)
        // in is Innovation
        // cv is Customer/Public Value & Impact
        // mk is Marketability
        // bm is Business Model
        // cp is Commercial Potential
        // at is Application of Technology
        // eu is Ease of Use
        // cr is Compatibility & Reliability
        // qs is Quality & Standards
        // pw is Proof of Concept / Working Prototype
        // cs is Content Structure
        // va is Visual Appeal
        // pc is Pitching
        // rp is Responsiveness
        

        $arr=['in','cv','mk','bm','cp','at','eu','cr','qs','pw','cs','va','pc','rp'];
        $data=$request->all();

        $data = array_map(function($value) {
            return $value == null ? 0 : $value;
        }, $data);

        foreach ($arr as $key => $value) {
            if(!array_key_exists($value, $data)){
                $data=$data+[$value=>0];
            }
        }
        $va=$this->validatorScore($data);
        
        $app=$this->application->find($id);
        if(!$app){
            flash()->error(lang('Form Application does not found')); 
            return redirect()->back()->withInput();
        }else if($va->fails()){
            flash()->error(lang('Please check your given score. It must be between 0 and 10.')); 
            return redirect()->back()->withErrors($va)->withInput();
        }else{

            $cate=$app->user->category->id;
            $user_id=\Auth::id();
            $form=$this->judge->makeModel()->where('app_id',$id)->where('user_id',$user_id)->first();
            
            if(Carbon::now()->gt($end_date_judge)) 
            {
                if(\Setting::get('ALLOW_JUDGE_DRAFT','false')=='true'){
                    if(sizeof($form)>0&&$form->status==1){
                    $condition=true;
                    }else{
                        $condition=false;
                    }    
                }

                if(\Setting::get('ALLOW_JUDGE_ID',-1)==\Auth::user()->id){   
                    $condition=true; 
                }


            }
/*
            if(Carbon::now()->gt($end_judge->addDay())&&\Setting::get('ALLOW_JUDGE_DRAFT','false')=='true') 
            {
                if(sizeof($form)>0&&$form->status==1){
                    $condition=true;
                }else{
                    $condition=false;
                }
            }
 */           
            if(!$condition){
                if(\Setting::get('ALLOW_JUDGE_DRAFT')){
                    $msg="We are sorry, the online judging is closed due to the deadline since : <b>".$end_judge->toFormattedDateString()."</b> We allowed only for draft judging.";
                }

                 $msg="We are sorry, the online judging is closed due to the deadline since : <b>".$end_judge->toFormattedDateString()."</b>";
                $type="red";
                return view('layouts.message',compact('msg','type'));
            }

            $data['app_id']=$id;
            $data['category_id']=$cate;
            $data['user_id']=$user_id;
            $data['type']='semi';
            $cat_name=$app->user->category->name;
            $total=0;
            $data['status']=2;
            if(strcasecmp($cat_name,"Public Sector")==0||strcasecmp($cat_name,"Corporate Social Responsible")==0){
               
                $strag=(($data['in']+$data['cv'])/10)*50;
                $stotal=($strag/100)*50;
                $feature=(($data['at']/10)*30)+(($data['eu']/10)*20)+(($data['cr']/10)*25)+(($data['qs']/10)*25);
                $sfeature=(($feature/100)*30);

                // if($data['in']==0||$data['cv']==0||$data['at']==0||$data['eu']==0||$data['cr']==0||$data['qs']==0||$data['cs']==0||$data['va']==0||$data['pc']==0||$data['rp']==0){
                //         $data['status']=1;
                // }

            }else if(strcasecmp($cat_name,"Start-up Company")==0||strcasecmp($cat_name,"Digital Content")==0||strcasecmp($cat_name,"Private Sector")==0){

                $strag=((($data['in']+$data['cv']+$data['mk']+$data['bm'])/10)*25);
                $stotal=(($strag/100)*50);
                $feature=(($data['at']/10)*30)+(($data['eu']/10)*20)+(($data['cr']/10)*25)+(($data['qs']/10)*25);
                $sfeature=(($feature/100)*30);
                // if($data['in']==0||$data['cv']==0||$data['mk']==0||$data['bm']==0||$data['at']==0||$data['eu']==0||$data['cr']==0||$data['qs']==0||$data['cs']==0||$data['va']==0||$data['pc']==0||$data['rp']==0){
                //     $data['status']=1;
                // }
            }else if(strcasecmp($cat_name,"Research and Development")==0){

                $strag=(($data['in']/10)*50)+(($data['cv']/10)*20)+(($data['cp']/10)*30);
                $stotal=(($strag/100)*50);
                $feature=((($data['at']+$data['eu']+$data['cr']+$data['qs']+$data['pw'])/10)*20);
                $sfeature=(($feature/100)*30);
                // if($data['in']==0||$data['cv']==0||$data['cp']==0||$data['at']==0||$data['eu']==0||$data['cr']==0||$data['qs']==0||$data['pw']==0||$data['cs']==0||$data['va']==0||$data['pc']==0||$data['rp']==0){
                //     $data['status']=1;
                // }
            }

            $data['status']=$this->validateScore($cat_name,$data);
            $presentation=(($data['cs']/10)*30)+(($data['va']/10)*15)+(($data['pc']/10)*40)+(($data['rp']/10)*15);
            $spresentation=($presentation/100)*20;
            $total=$stotal+$sfeature+$spresentation;

            $data['total']=$total;
            $user=$this->user->find($user_id);

            $change_cate_num=$this->category->find($cate);  
            $cate_user=$user->categories;
            $numberform=0;
            if(isset($cate_user)){
                foreach ($cate_user as $key => $value) {
                    if($value->pivot->category_id==$cate){
                        $numberform=$value->pivot->num_form;
                        break;
                    }
                }
            }

            if(sizeof($form)>0){
                $old_status=$form->status;
                $sav=$form->update($data);

                if($old_status==2&&$data['status']==1){
                    $numberform=$numberform-1;
                }elseif ($old_status==1&&$data['status']==2) {
                    $numberform=$numberform+1;
                }

                $change_cate_num->users()->updateExistingPivot($user_id,['num_form'=>$numberform],false);

                if($sav){
                    if($data['status']==1){
                        flash()->warning(lang('Application Form has been updated successfully. Some fields are contains 0 point so this judge is put as draft. You must field all the content with bigger than 0 number then it will be moved to tab Judging Completed.')); 
                    }elseif($data['status']==2){
                        flash()->success(lang('Application Form has been updated successfully. It is moved to tab Judging Completed. We will consider this judgement later.')); 
                    }
                    
                    return redirect(route('application.aseanapp'));
                }
            }else{
                $sav=$this->judge->create($data);
                if($sav){
                    if($data['status']==2){
                        $numberform=$numberform+1;
                    }
                    // $form_user=$this->user->find($form->user_id);
                    $fcate=$this->category->find($cate);
                    $fcate->users()->updateExistingPivot($user_id,['num_form'=>$numberform],false);
                    
                    if($data['status']==1){
                        flash()->warning(lang('Application Form has been updated successfully. Some fields are contains 0 point so this judge is put as draft. You must field all the content with bigger than 0 number then it will be moved to tab Judging Completed.')); 
                    }elseif($data['status']==2){
                        flash()->success(lang('Application Form has been updated successfully. It is moved to tab Judging Completed. We will consider this judgement later.')); 
                    }

                    return redirect(route('application.aseanapp'));
                }else{
                    flash()->error(lang('Some error occure during process.')); 
                    return redirect()->back()->withInput();
                }
            }
        }
        // $data['in']=-5;
        
        
    }

    public function jlist()
    {
        return view('judge.list');
        
    }

     public function getListJudge()
    {
        $user = $this->user->makeModel()->where('parent_id','=',null)->where('is_super_admin','!=','1')->orderBy('username', 'asc')->get();
        $judges=[];
        foreach ($user as $value) {
            if($value->hasRole('Judge')){
                $judges[]=$value;
            }
        }
        return Datatables::of($judges)
            ->addColumn('id',function ($user){
                    return $this->idTable++;
                })
            ->addColumn('name', function ($user) {
                    return ucwords($user->username);
                })
            ->addColumn('email', function ($user) {
                    return ucwords($user->email);
                })
            ->addColumn('role', function ($user) {
                    return count($user->roles)>0?$user->roles[0]->name:"";
                })
            ->addColumn('country',function($user){
                return $user->country?$user->country->name:"Cambodia";
            })
            ->addColumn('action', function ($user) {
                    $result = '<a href="'.route('judge.edit', $user->id).
                    '" class="btn btn-icon btn-primary btn-xs m-b-3" title="Edit" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>';
                    
                    
                    $result .= '<a onclick="javascript:clickDestroy(this); return false;" data-item="'.$user->id.'" href="'.route('judge.destroy', $user->id).'" class="sw-delete btn btn-icon btn-danger btn-xs m-b-3" title="Delete" ><i class="fa fa-trash-o"></i></a>';
                    return $result;
                })
            ->make(true);
    }

    public function edit(FormBuilder $formBuilder,$id)
    {
        // $this->admin=\Auth::user()->is_super_admin||\Auth::user()->hasRole('Admin');
        
        $userInfor = $this->user->find($id);
        $url=route('judge.postedit',$id);
        $form = $formBuilder->create(JudgeForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  $url,
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'novalidate'=>  'novalidate',
                'model'     =>  $userInfor
            ]
        );
        $form->remove('password');
        $form->remove('type');
        $form->remove('password_confirmation');
        $form->remove('country_id');
        $form->remove('category_id');
        return view('judge.edit', compact('form'));

    }
    public function update(Request $request){
        $this->validatorUpdate($request->all())->validate();
        $id=$request->get("id");
        $this->user->find($id)->update($request->all());
        flash()->info(lang('The record was updated.')); 
        return redirect(route('judge.jlist'));
    }

    public function postDelete()
    {
        $id_item = Input::get('item');
        if($id_item){
            $user=$this->user->find($id_item);
            $user->categories()->sync([]);
            $user->judges()->delete();
            $user->removeRole('Judge');
            $role=$user->hasAnyRole(\App\Entities\Role::all());
            if(!$role){
                $user->delete();
            }
            return "success";
        }
        return "failed";
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'category_id'=>'required',
            'country_id'=>'required',
        ]);
    }

    protected function validatorUpdate(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$data['id'],
        ]);
    }

    protected function validatorScore(array $data)
    {
        // dd($data);
        return Validator::make($data, [
            'in'=>'numeric|min:0|max:10',
            'cv'=>'numeric|min:0|max:10',
            'mk'=>'numeric|min:0|max:10',
            'bm'=>'numeric|min:0|max:10',
            'cp'=>'numeric|min:0|max:10',
            'at'=>'numeric|min:0|max:10',
            'eu'=>'numeric|min:0|max:10',
            'cr'=>'numeric|min:0|max:10',
            'qs'=>'numeric|min:0|max:10',
            'pw'=>'numeric|min:0|max:10',
            'cs'=>'numeric|min:0|max:10',
            'va'=>'numeric|min:0|max:10',
            'pc'=>'numeric|min:0|max:10',
            'rp'=>'numeric|min:0|max:10'
        ]);
        
    }

    protected function create(array $data)
    {
            return User::create([
                        'username' => $data['username'],
                        'email' => $data['email'],
                        'password' => bcrypt($data['password']),
                        'country_id'=>$data['country_id'],
                        'active'=>'1',
                        'is_super_admin'=>0,
                    ]);

    }

    // 1 means draft judged
    // 2 means already judged
    
    protected function validateScore($cat_name,$data){
        $status=0;
        if(strcasecmp($cat_name,"Public Sector")==0||strcasecmp($cat_name,"Corporate Social Responsible")==0){
            if($data['in']==0||$data['cv']==0||$data['at']==0||$data['eu']==0||$data['cr']==0||$data['qs']==0||$data['cs']==0||$data['va']==0||$data['pc']==0||$data['rp']==0)
            {
                $status=1;
            }else{
                $status=2;
            }
        }else if(strcasecmp($cat_name,"Start-up Company")==0||strcasecmp($cat_name,"Digital Content")==0||strcasecmp($cat_name,"Private Sector")==0){
            if($data['in']==0||$data['cv']==0||$data['mk']==0||$data['bm']==0||$data['at']==0||$data['eu']==0||$data['cr']==0||$data['qs']==0||$data['cs']==0||$data['va']==0||$data['pc']==0||$data['rp']==0){
                $status=1;
            }else{
                $status=2;
            }
        }else if(strcasecmp($cat_name,"Research and Development")==0){
            if($data['in']==0||$data['cv']==0||$data['cp']==0||$data['at']==0||$data['eu']==0||$data['cr']==0||$data['qs']==0||$data['pw']==0||$data['cs']==0||$data['va']==0||$data['pc']==0||$data['rp']==0){
                $status=1;
            }else{
                $status=2;
            }
        }

        return $status;

    }

    // public function migrateNewStatus(){
    //     $judge=$this->judge->makeModel()->get();
    //     $cate_arr=['1'=>"Public Sector",'2'=>"Private Sector",'3'=>"Corporate Social Responsible",'4'=>"Digital Content",'5'=>"Start-up Company",'6'=>"Research and Development"];
    //     foreach ($judge as $value) {
    //         // dd($cate_arr[$value->category_id]);
    //         // dd($value->toArray());
    //         $status=$this->validateScore($cate_arr[$value->category_id],$value->toArray());
    //         if($status==1){
    //             $change_cate_num=$this->category->find($value->category_id);  
    //             $user=$this->user->find($value->user_id);
    //             $cate_user=$user->categories;
    //             $numberform=0;
    //             if(isset($cate_user)){
    //                 foreach ($cate_user as $key => $valusercate) {
    //                     if($valusercate->pivot->category_id==$value->category_id){
    //                         $numberform=$valusercate->pivot->num_form;
    //                         break;
    //                     }
    //                 }
    //                 if($numberform>0){
    //                     $numberform=$numberform-1;
    //                 }else{
    //                     $numberform=0;
    //                 }
                    
    //                 $change_cate_num->users()->updateExistingPivot($value->user_id,['num_form'=>$numberform],false);
    //             }
    //         }elseif($status==2){
    //             $jud=$this->judge->find($value->id);
    //             $jud->update(['status'=>2]);
    //         }
    //         // return "complete";
    //         // $arr['in']=$value->in;
    //         // $arr['cv']=$value->cv;
    //         // $arr['mk']=$value->mk;
    //         // $arr['bm']=$value->bm;
    //         // $arr['cp']=$value->cp;
    //         // $arr['at']=$value->at;
    //         // $arr['eu']=$value->eu;
    //         // $arr['cr']=$value->cr;
    //         // $arr['qs']=$value->qs;
    //         // $arr['pw']=$value->pw;
    //         // $arr['cs']=$value->cs;
    //         // $arr['va']=$value->va;
    //         // $arr['pc']=$value->pc;
    //         // $arr['rp']=$value->rp;
                         

    //     }
    //     return "Complete";
    // }


    public function finalJudge($id){
        $auth=\Auth::user();
        $condition=true;
        $user_id=\Auth::id();
        $form=$this->judge->makeModel()->where('app_id',$id)->where('user_id',$user_id)->first();



    }

    private function __calculateFinalScore(){
        return 0;
    }
}
