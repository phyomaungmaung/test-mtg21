<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Entities\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Forms\CandidateForm;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Input;
use App\Repositories\CandidateRepository;
use App\Repositories\CategoryRepository;
use App\Entities\CategoryUser;
use function MongoDB\BSON\toJSON;
use Yajra\DataTables\DataTables;

use Carbon\Carbon;

class CandidateController extends Controller
{

    use RegistersUsers;

    protected $redirectTo = '/candidate';

    public function __construct(CandidateRepository $user,CategoryRepository $category)
    {
        $this->middleware('auth');
        $this->idTable = (intval(Input::get('start')))+1;
        $this->user=$user;
        $this->category=$category;
    }
    public function showRegistrationForm(FormBuilder $formBuilder)
    {
        $user=\Auth::user();
        $form = $formBuilder->create(CandidateForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  route('candidate.create'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                // 'novalidate'=>  'novalidate'
            ]
        );
        $edited=false;
        $isadmin=true;
//        $form->remove('category_id') ;//@TODO: why remove?
        if($user->is_super_admin!=1&&!$user->hasRole(ucwords('Admin'))){
            $isadmin=false;
            $form->remove('country_id');
        }
        return view('candidate.create',compact('edited','form','isadmin'));
    }

    public function register(Request $request)
    {
        $id = $request->get('id');
        $auth=\Auth::user();
        $reciever=$request->get('email');
        $country_id=$request->has('country_id')?$request->get('country_id'):\Auth::user()->country_id;

        $error_message=[];
        $user=[];
        $pwd=$this->_getGeneratePassword();
        if(!$id){
            $request['password']=$pwd;
            $request['password_confirmation']=$pwd;
            $request['roles']="Candidate";
            $this->validator($request->all())->validate();
            if(\Setting::get("LIMIT_CAT_PER_CANDIDATE",1)>1){
//                @todo : save multi Cat per Candidate
            }else{
                if($this->detectedLimitCandiatePerCountry($request->get('category_id'),$country_id)){
                    if(!$this->_sendMailRegistered($request,$pwd)){
                        $error_message['wanrning']='We met some problems during sending email to user';
                    }
                    $error_message['success']="Your data was created.";
                    $user = $this->create($request->all());
                    $user->categories()->attach(
                        ["category_id"=>$request->get('category_id')],
                        ["country_id"=>$country_id ,'type'=>'candidate']);
                    $user->assignRole('Candidate');
                    event(new Registered($user));

                }else{
                    return redirect()->back()
                        ->withInput()
                        ->with(['edited'=>false])->withErrors(['error'=>"Cannot create Candidate with category ".$this->category->find($request->get('category_id'))->name.' more than '. \Setting::get('LIMIT_CANDIDATE',3)]);
                }
                return $this->registered($request, $user)
                    ?: redirect($this->redirectPath())->with($error_message);
            }

        }else{
//            case edit
            $this->admin=$auth->is_super_admin||$auth->hasRole('Admin')||$auth->hasRole('Representer');
            $userInfor = $this->user->find($id);
            if($this->admin){
                $arr_edit=['username'=>$request['username'],'email'=>$request['email'],'category_id'=>$request['category_id'],'country_id'=>$country_id ];
            }else{
                $arr_edit=['username'=>$request['username'],'email'=>$request['email'] ];
            }
            $this->validatorEdit($request->all())->validate();
            if($this->detectedLimitCandiatePerCountry($request->get('category_id'),$country_id,$userInfor)){
                if(isset($userInfor)&&$userInfor->remember_token==null){
                    if($request['email']!=$userInfor->email){
                        if(!$this->_sendMailRegistered($request,$pwd)){
                            $error_message['warning']='We met some problems during sending email to user';
                        }
                        $arr_edit=['username'=>$request['username'],'email'=>$request['email'],'password'=>bcrypt($pwd) ];
                    }
                }
                $userInfor->update($arr_edit);
//                @todo: attach or sys?
//                $userInfor->categories()->attach($request->get('category_id'),[ "country_id"=>$request->get('country_id')],
//                    ["type"=>"candidate"]);
                $userInfor->syncRoles('Candidate');
                $userInfor->categories()->sync([$request['category_id']=>['country_id'=>$country_id,'type'=>'candidate']]);
            }else{

                return redirect()->back()
                            ->withInput()
                            ->with(['edited'=>true])
                            ->withErrors(['error'=>'Cannot change user category to '
                                    .$this->category->find($request->get('category_id'))->name
                                    .'. It is reach to limit '.\Setting::get('LIMIT_CANDIDATE',3).'.']);
            }
            return redirect(route('candidate.index'))->with($error_message);
        }
        
        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
        
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'category_id'=>'required',
        ]);
    }

    protected function validatorEdit(array $data)
    {
        $id  =   Input::get('id', '');
        return Validator::make($data, [
            'username' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'category_id'=>'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user=\Auth::user();
        if($user->hasRole('Admin')||$user->is_super_admin==1){
            return $this->user->create([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'active'=>'1',
                    'is_super_admin'=>0,
                    'parent_id'=>$user->id,
                    'category_id'=>$data['category_id'],
                    'country_id'=>$data['country_id'],
                ],['type'=>"candidate"]);
        }else{
            return $this->user->create([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'active'=>'1',
                    'is_super_admin'=>0,
                    'parent_id'=>$user->id,
                    'category_id'=>$data['category_id'],
                    'country_id'=>$user->country_id,
                ],['type'=>"candidate"]);
        }

    }

    public function index()
    {
//        $start_judge = Carbon::createFromFormat('m/d/Y', '06/12/2019');
//        dd($start_judge->isPast());
        return view('candidate.index');
    }
    
     public function getList()
    {

        $user=[];
         if(\Auth::user()->hasRole('Representer')){

             $user = $this->user->makeModel()
                 ->whereHas('roles',function($q){ $q->where("name", "Candidate"); })
                 ->whereHas('categoryUsers',function($a){$a->where('country_id',\Auth::user()->country_id);})
                 ->orderBy('username', 'asc')->get();
        }else if(\Auth::user()->hasRole("Admin") || \Auth::user()->is_super_admin){
             $user = $this->user->makeModel()
                 ->whereHas('roles',function($q){ $q->where("name", "Candidate"); })
                 ->orderBy('username', 'asc')->get();
         }
        return Datatables::of($user)
            ->addColumn('id',function ($user){
                    return $this->idTable++;
                })
            ->addColumn('name', function ($user) {
                    return ucwords($user->username);
                })
            ->addColumn('email', function ($user) {
                    return ucwords($user->email);
                })
            ->addColumn('category', function ($user) {
                    return ucwords(!isset($user->candidateCategories)?"":isset($user->candidateCategories[0])?$user->candidateCategories[0]->name:"");
                })
            ->addColumn('country', function ($user) {
                    return ucwords(!isset($user->countries)?"":isset($user->countries[0])?$user->countries[0]->name:"");
                })
            ->addColumn('action', function ($user) {
                    $result="";
                    if(\Auth::user()->is_super_admin==1||\Auth::user()->hasPermissionTo("edit-candidate")){
                        $result .= '<a href="'.route('candidate.edit', $user->id).
                        '" class="btn btn-icon btn-primary btn-xs m-b-3" title="Edit" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>';
                    }
                    if(\Auth::user()->is_super_admin==1||\Auth::user()->hasPermissionTo("delete-candidate")){
                        $result .= '<a onclick="javascript:clickDestroy(this); return false;" data-item="'.$user->id.'" href="'.route('candidate.destroy', $user->id).'" class="sw-delete btn btn-icon btn-danger btn-xs m-b-3" title="Delete" ><i class="fa fa-trash-o"></i></a>';
                    }
                    return $result;
                })
            ->make(true);
    }

    public function edit(FormBuilder $formBuilder,$id)
    {
        $userInfor = $this->user->find($id);

        if(!isset($userInfor) && isset($userInfor->id)){
            return redirect(route('candidate.index'))->with(["error"=>"Request not found"]);
        }
        $category = $userInfor->categories[0]->id;
        $userInfor['category_id']=$category;
        $userInfor['country_id']=isset($userInfor->categoryUsers[0])?$userInfor['country_id']:$userInfor->categoryUsers[0]->country_id;
        $user=\Auth::user();
        if(
            (!$user->hasRole(ucwords('Admin'))) &&
            ($user->is_super_admin!=1)&&
            (!$user->hasPermissionTo('edit-candidate') || $user->country_id != $userInfor->country_id)
        ){
//        if(($userInfor->parent_id!=\Auth::id())&&($user->is_super_admin!=1)&&(!$user->hasRole(ucwords('Admin')))){
//            flash()->warning("You have no permission.");
            return redirect(route('candidate.index'))->with(['warning'=>"You have no permission."]);
        }
        
        $form = $formBuilder->create(CandidateForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  route('candidate.store'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                //'novalidate'=>  'novalidate',
                'model'     =>  $userInfor
            ]
        );
        $isadmin=true;
        if($user->is_super_admin!=1&&!$user->hasRole(ucwords('Admin'))){
            $isadmin=false;
            $form->remove('country_id');
        }
//      check dateline
        if(is_deadline('started_judgement_date') && $user->is_super_admin!=1){
            $title="Message";
            $type="red";
            $msg ="Judging date is started Cannot update !! \n Contact admin if you still need to update.";
            return view('layouts.message', compact('title','type', 'msg'));
        }


        $form->remove('password');
        $form->remove('password_confirmation');
//      $todo:
        $form->remove('categories');
        //$form->remove('admin');
        $edited = true;
        $admin=$userInfor;
        return view('candidate.create', compact('form','edited','admin','isadmin'));
    }

    public function postDelete()
    {
        // todo: work for 1 user 1 application

        $id_item = Input::get('item');
        if($id_item){
            $user=$this->user->find($id_item);
            $is_admin = \Auth::user()->is_super_admin ==1 || \Auth::user()->hasRole('Admin');
            if(!$user){
                return json_encode(['error'=>1,'mess'=>"Candidate not Found!!"]);
            }

//            if($user->hasAnyRole(["Judge","Final Judge"])&& !$is_admin ){
//                return json_encode(['error'=>1,'mess'=>"This user may be also Judge or Final Judge, Contact System Admin to delete!!"]);
//            }
            if(is_deadline('started_judgement_date') && $user->is_super_admin!=1){
                return json_encode(['error'=>1,'mess'=>"Online Judging is started \n please contact admin if you wish to delete !"]);
            }

            if(!$user->hasRole('Candidate')){
                return json_encode(['error'=>1,'mess'=>"Try to delete non candidate!!"]);
            }
            if($user->application){
                if(!$is_admin){
                    return json_encode(['error'=>1,'mess'=>"This Candidate has fill the form, Contact Admin to delete!!"]);
                }
                if($user->application->videos()){
                    $user->application->videos()->delete();
                }
//                return "success";
                $user->application->delete();
            }
            $user->categories()->detach();
            return $user->delete()? "success":"failed";

        }
        
        return "failed";
    }

    public function getDelete($id_item)
    {
        // todo: work for 1 user 1 application
//        $id_item = Input::get('item');
//        if($id_item){
//            $user=$this->user->find($id_item);
//            if($user && $user->hasRole('Candidate')){
//                if($user->application){
//                    $user->application->delete();
//                }
//                $user->categories()->detach();
//                $user->delete();
//                return "success";
//            }
//        }

        return "failed";
    }

    private function detectedLimitCandiatePerCountry($id_category,$id_country,$user=null){
        if($user){
            $c =$user->categories()->where('country_id',$id_country)->where('category_id',$id_category)->where('type','candidate')->count();
            if($c>0){
                return true;
            }
        }
        $num = CategoryUser::where('country_id',$id_country)->where('category_id',$id_category)->where('type','candidate')->count();
        return $num < \Setting::get('LIMIT_CANDIDATE','3');
    }




}
