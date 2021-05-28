<?php

namespace App\Http\Controllers;

use App\Entities\Category;
use App\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Forms\JudgeForm;
use Illuminate\Auth\Events\Registered;
use App\Repositories\UserRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ApplicationRepository;
use Yajra\DataTables\DataTables;
use App\Entities\Country as Country;
use Carbon\Carbon;
use App\Entities\CategoryUser;
use App\Repositories\JudgeRepository;

class JudgeController extends Controller
{

    use RegistersUsers;

    protected $redirectTo = '/judge';

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

    public function index()
    {

        $countries = $this->country
            ->select('id','name')
            ->orderBy('name', 'asc')
            ->get();
        $categories = $this->category->makeModel()
            ->select('id','name')
            ->orderBy('name', 'asc')
            ->get();
        return view('judge.index',compact("categories","countries"));
    }
    public function getList(Request $request){
        $auth=\Auth::user();
        $judge = CategoryUser::whereIn('type',['semi','final'])->get();
//        if($request->has('type') && $request->get('type')!=""){
//            $judge = $judge->where('type',$request->get('type'));
//        }
        if($auth->is_super_admin != 1 && !$auth->hasRole('Admin') && $auth->country_id <> "" ){
            $judge = $judge->where('country_id',$auth->country_id);
        }
        $formInCats= CategoryUser::where('type','candidate')
            ->whereHas('user',function($u){
                $u->whereHas("application", function($q){ $q->where("status", "accepted"); });
            })
            -> select('*',\DB ::raw('count(*) as total' ))->groupBy('category_id')->get()->pluck('total','category_id')->toArray();

        return Datatables::of($judge)
            ->filter(function ($instance) use ($request) {
                if ($request->has('type')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return $request->get('type')==""?true :$request->get('type')==$row['type'] ? true :false;
                    });
                }
                if ($request->has('coun')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return $request->get('coun')==""?true :$request->get('coun')==$row['country_id'] ? true :false;
                    });
                }

                if ($request->has('cat')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return $request->get('cat')==""?true :$request->get('cat')==$row['category_id'] ? true :false;
//                            return Str::contains($row['category'], $request->get('category')) ? true : false;
                    });
                }
            })
            ->addColumn('id',function ($user){
                return $this->idTable++;
            })
            ->addColumn('username', function ($judge) {
                return ucwords($judge->judge['username']);
            })
            ->addColumn('email', function ($user) {
                return ucwords($user->judge['email']);
            })
            ->addColumn('role', function ($user) {
                return ucwords($user['type']=='semi'?"Judge":"Final Judge");
            })
            ->addColumn('country',function($user){
                return ucwords($user->country['name']);
            })
            ->addColumn('category', function ($user) {
                return ucwords($user->category['name']);
            })
            ->addColumn('action', function ($user) use ($formInCats){
                $total = isset($formInCats[$user['category_id']]) ?$formInCats[$user['category_id']]:$user['num_form'];
                $result = '';
                $result .= ' <div class="btn btn-icon btn-danger btn-xs m-b-3" title="Draft Judged" style="margin-right: 5px;"><i class="">'.($total-$user['num_form']).'</i></div>';
                $result .= '  <div class="btn btn-icon btn-success btn-xs m-b-3" title="Complete Judged" style="margin-right: 5px;"><i class="">'.$user['num_form'].'</i></div>';
                $result .= '<a href="'.route('judge.edit', ['id'=>$user->user_id,'type'=>$user['type']]).
                    '" class="btn btn-icon btn-primary btn-xs m-b-3" title="Edit" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>';
                $result .= '<a onclick="javascript:clickDestroy(this); return false;" data-item='.json_encode(['id'=>$user->user_id,'type'=>$user['type'],'country_id'=>$user['country_id'],'category_id'=>$user['category_id']]).' href="'.route('judge.destroy', ['id'=>$user->user_id]).'" class="sw-delete btn btn-icon btn-danger btn-xs m-b-3" title="Delete" ><i class="fa fa-trash-o"></i></a>';
                return $result;
//            })
//            ->addColumn('form', function ($user)  {

//                 return $result;
            })
            ->rawColumns(['action','form'])
            ->make(true);
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
        $country=$this->country->pluck('name','id');
        $category=$this->category->makeModel()->orderBy('name')->pluck('name','id');
        $type=['Judge'=>'Online Judge','Final Judge'=>'Final Judge'];
        $country['']='Select Country';
        return view('judge.create',compact('country','category','form','type'));
    }

    public function listCateUsed(Request $request){

        $type=$request->input('utype');
        if($type=='Judge'){
            $type='semi';
        }else if($type=='Final Judge'){
            $type='final';
        }
        $user_id = null;
        if($request->has('user_id')){
           $user_id= $request->get('user_id');
        }
         $user= $this->__getIdsUsedCategory($type,$request->get('country_id'),$user_id);

        return json_encode( $user);
    }
/*
 * categories of a user
 */
    public function listcate(Request $request,$id){
        $user = $this->user->find($id);
        $type=$request->input('utype');
        if($type=='Judge'){
            $type='semi';
            return $user->onlineCategories()->get()->pluck('id')->toJson();
        }else if($type=='Final Judge'){
            $type='final';
            return $user->finalCategories()->get()->pluck('id')->toJson();
        }
        return json_encode([]);
    }

    public function store(Request $request){
//        save exist
        if($request->has('')){

        }
    }
    
    public function saveExisted(Request $request){
        if($request->has('id') && !$request->has('id_user')){
            // edit judge information
            $valid=$this->validate($request, [
                'country_id' => 'required',
                'id' => 'required',
                'category_id' => 'required',
                'username' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email,'.$request->get('id'),
                'type' => 'required',
            ]);
            $coun = $request->get("country_id");
            $getType=$request->get('type');
            $user= $request->get("id");
            $cate=$request->get("category_id");
            $u = $this->user->find($user);
            $u->update(['username'=>$request->get('username'),'email'=>$request->get('email'),'country_id'=>$coun]);
        }else{
            $valid=$this->validate($request, [
                'id_country' => 'required',
                'id_user' => 'required',
                'id_cate' => 'required',
            ]);
            $coun = $request->get("id_country");
            $getType=$request->get('id_type');
            $user= $request->get("id_user");
            $cate=$request->get("id_cate");

        }
        $indust =  array_values(\Settings::get('industries',[]));
        $is_start_online_judge= is_deadline('STARTED_JUDGEMENT_DATE') && \Auth::user()->is_super_admin !=1;
        if(\Auth::user()->is_super_admin !=1){
            if( $is_start_online_judge && $getType=='Judge'){
//            check if start online judge
                return redirect()->back()->withInput()->withErrors("Operation Fail due to Start to Final judge now!!  Contact System admin!!");
            }else if($getType=="Final Judge"&& is_deadline(\Carbon\Carbon::createFromFormat("m/d/Y",\Settings::get("FINAL_JUDGE_DATE",'06/20/2019'))->addDays(-1))){
                return redirect()->back()->withInput()->withErrors("Operation Fail due to Start to Final judge now!! Contact System admin!!");
            }
        }
        $getCount=$this->country->find($coun);
        $check_coun=true;
        $err_form=true;
        $list_cat="";
        $mess = [];
//        @todo: check type when start online judge
        if($valid){
            if($getType=="Judge" && !in_array($getCount,$indust)) {
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
                    return redirect()->back()->withInput()->withErrors(['error'=>lang('general.validate_jude_for_country',['cat'=>trim($list_cat,', ')])])->with(['err_form'=>$err_form,'err_cate'=>json_encode($err_cate)]);
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
                    return redirect(route('judge.index'))->with(['info'=>'The record was saved.']);
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
                    if(sizeof($cate)>0){
                        $err_cate=array_values($cate);
                    }else{
                        $err_cate=[];
                    }
                    return redirect()->back()->withInput()->withErrors(['error'=>lang('general.validate_jude_for_country',['cat'=>trim($list_cat,', ')])])->with(['err_form'=>$err_form,'err_cate'=>json_encode($err_cate)]);
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
                    return redirect(route('judge.index'))->with(['info'=>'The record was saved.']);
                }
            }
            
        }
    }

    public function register(Request $request)
    {
       
        $this->validator($request->all())->validate();
        $valid=true;
        $indust =  array_values(\Settings::get('industries',[]));
        // $getCount=$this->country->find($coun);
        $getType=$request->get('type');
        $list_cat="";
        $coun=$request->get('country_id');
        $cate=$request->get('category_id');
        $pwd=$this->_getGeneratePassword();
        $request['password']=$pwd;
        $request['password_confirmation']=$pwd;
        $request['roles']=$getType;
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
                if($this->_sendMailRegistered($request,$pwd)){
                    $mes["warning"]="We met some problems during sending email to user";
                }
                $arr=[];
                foreach ($cate as $key => $value) {
                    $arr[$value]=['num_form'=>'0','country_id'=>$request->get('country_id'),'type'=>'semi'];
                }
                $user->categories()->sync($arr);
                return redirect(route('judge.create'))->with(['info'=>'The record was saved.']);
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
                if($this->_sendMailRegistered($request,$pwd)){
                    $mes["warning"]="We met some problems during sending email to user";
                }
                $arr=[];
                foreach ($cate as $key => $value) {
                    $arr[$value]=['num_form'=>'0','country_id'=>$request->get('country_id'),'type'=>'final'];
                }
                $user->categories()->sync($arr);

                return redirect(route('judge.create'))->with(['info'=>lang('The record was saved.')]);
            }else{
                return redirect()->back()->withInput()->withErrors(["err_valid"=>lang('general.validate_jude_for_country',['cat'=>trim($list_cat,', ')])]);
            }
        }
        
    }
 
    public function lists(){ 
        return view('judge.index');
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
    /*
     * edit information of judge
     */
    public function edit(FormBuilder $formBuilder,$id,$type)
    {
         $admin=\Auth::user()->is_super_admin||\Auth::user()->hasRole('Admin');
         if(!in_array($type,['final','semi'])){
             return redirect()->back()->withErrors(['error'=>"Invalid type"]);
         }
        $userInfor = $this->user->find($id);
        $role = $type=="semi"?"Judge":"Final Judge";
        $userInfor['type']=$role;
        $selects = $this->__getIdsUsedCategoryByUser($type,$userInfor->country_id,$userInfor->id);
        $userInfor['category_id']=$selects;
        $url=route('judge.saveexisted');
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
        $disables = $this->__getIdsUsedCategory($type,$userInfor->country_id,$userInfor->id);
        $is_start_online_judge = is_deadline('STARTED_JUDGEMENT_DATE');

        if(\Auth::user()->is_super_admin !=1){
            if($type=='semi' && $is_start_online_judge ){
                return view('layouts.message')->with(['type'=>"red",'msg'=>"Start to Online judge now!! \n Contact System admin to delete !!"]);
            }else if($type=='final'&& is_deadline(\Carbon\Carbon::createFromFormat("m/d/Y",\Settings::get("FINAL_JUDGE_DATE",'08/20/2019'))->addDays(-1))){
                return view('layouts.message')->with(['type'=>"red",'msg'=>"Start to Final judge now!! \n Contact System admin to delete !!"]);

            }
        }
        if($is_start_online_judge){
            $form->modify('type','hidden');
        }
        $country=$this->country->pluck('name','id');
        $category=$this->category->makeModel()->orderBy('name')->pluck('name','id');
        $type=['Judge'=>'Online Judge','Final Judge'=>'Final Judge'];
        $country['']='Select Country';
        return view('judge.edit',compact('country','category','form','type','disables','is_start_online_judge'));


    }
    public function update(Request $request){
        $this->validatorUpdate($request->all())->validate();
        $id=$request->get("id");
        $this->user->find($id)->update($request->all());
        return redirect(route('judge.jlist'))->with(['info'=>lang('The record was updated.')]);
    }

    public function postDelete(Request $request)
    {


        $validate =Validator::make($request->toArray(), [
            'id' => 'required',
            'type' => 'required',
            'country_id' => 'required',
            'category_id'=>'required',
        ]);
        if($validate->fails()){
            return json_encode(['error'=>1,'mess'=>'Invalid Information !!']);
        }
        $is_start_online_judge = is_deadline('STARTED_JUDGEMENT_DATE');
        if(\Auth::user()->is_super_admin !=1){
            if($is_start_online_judge && $request->get('type')=='semi'){
//            check if start online judge
                return json_encode(['error'=>1,'mess'=>"Start to Online judge now!! \n Contact System admin to delete !!"]);
            }else if($request->get('type')=='final'&& is_deadline(\Carbon\Carbon::createFromFormat("m/d/Y",\Settings::get("FINAL_JUDGE_DATE",'06/20/2019'))->addDays(-1))){
                return json_encode(['error'=>1,'mess'=>"Start to Final judge now!! \n Contact System admin to delete !!"]);
            }
        }

        $auth=\Auth::user();
        $user = $this->user->find($request->get('id'));
        $type = $request->get('type');
        $judge=$user->categories();
        $count = $judge->count();
        $judge = $judge->wherePivot('type',$request->get('type'));
        $count_in_type = $judge->count();
        if($auth->is_super_admin != 1 && !$auth->hasRole('Admin') && $request->has('country_id')){
            $judge = $judge->wherePivot('country_id',$request->get('country_id'));
        }
        $judge->detach($request->get('category_id'));
        if($count_in_type<=1){
            $user->removeRole($type=='semi'?'Judge':"Final Judge");
        }
        if($count<=1){

            if(!$user->hasAnyRole(["Admin","Representer","Reviewer"])){
                $user->syncRoles([]);
                $user->categories()->sync([]);
                $user->delete();
                if($user->application){
                    $user->application->delete();
                }
            }

        }
        return "success";
    }

    public function  cleanUnusedScore($ype=null){
        $user = \Auth::user();

        $categories = $this->category->all();
        foreach ($categories as $category){
            $this->_cleanSemi($category,'semi');
        }
        $this->judge->makeModel()->where('type',"semi")
//            ->where('category_id',$category->id)
            ->whereDoesntHave("application")
            ->delete();
        foreach ($categories as $category){
            $this->_cleanSemi($category,'final');
        }

        $this->judge->makeModel()->where('type',"final")
//            ->where('category_id',$category->id)
            ->whereDoesntHave("application")
            ->delete();
        return redirect()->back()->with(["info"=>"records are  clean"]);

    }

    private function _cleanSemi(Category $category,$type="semi"){

        $user_cats = CategoryUser::where('type',$type)->where('category_id',$category->id)->get();
        foreach ($user_cats as $user){
            $judges = $this->judge->makeModel()->where('type',$type)
            ->where('category_id',$category->id)
//            ->where('status',1)
            ->where('user_id',$user->user_id)
            ->wherehas("application",function ( $query) {
                $query->where('id', '!=', null);
            })
            ->get();
            $n = $judges->count();
            if($user->num_form != $n){
//                $t =$user->num_form;
                $user->update(['num_form'=>$n]);
            }
            $this->judge->makeModel()->where('type',$type)
                ->where('category_id',$category->id)
//            ->where('status',1)
                ->where('user_id',$user->user_id)
                ->whereDoesntHave("application")
                ->delete();
        }

/*
        $judges = $this->judge->makeModel()->where('type','semi')
//            ->where('category_id',$category->id)
//            ->where('status',1)
//            ->whereNotIn('user_id',$judgs)
            ->wherehas("application",function ( $query) {
                $query->where('id', '!=', null);
            })
            ->get();
        dd($judges);

        // */
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
//            'password' => 'required|min:6|confirmed',
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

    public function finalJudge($id){
        $auth=\Auth::user();
        $condition=true;
        $user_id=\Auth::id();
        $form=$this->judge->makeModel()->where('app_id',$id)->where('user_id',$user_id)->first();
    }

    private function __getIdsUsedCategoryByUser($type,$country_id,$user_id){

        $user= CategoryUser:: where('country_id',$country_id)->where('user_id',$user_id)
            ->where('type',$type)->get();
        return $user->pluck('category_id')->toArray();
    }

    private function __getIdsUsedCategory($type,$country_id,$user_id=null){

        $user= CategoryUser:: where('country_id',$country_id)
            ->where('type',$type)->get();
        if($user_id!=null){
            $user = $user->where('user_id','!=',$user_id);
        }
        return $user->pluck('category_id')->toArray();
    }
}
