<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Entities\CategoryUser;
use App\Entities\Role;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Forms\UserForm;
use App\Forms\ProfileForm;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Input;
use App\Repositories\UserRepository;
use App\Forms\PasswordForm;

use Yajra\DataTables\DataTables;
use App\Entities\Country as Country;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user,Country $country, CategoryRepository $category)
    {
        $this->middleware('auth');
        $this->idTable = (intval(Input::get('start')))+1;
        $this->user=$user;
        $this->admin=0;
        $this->country=$country;
        $this->category= $category;
    }
    public function showRegistrationForm(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create(UserForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  route('register'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'novalidate'=>  'novalidate'
            ]
        );
        $form->remove('country_id');
        $form->remove('category_id');
        $edited=false;
        $user=\Auth::user();
        $admin=$user->hasRole('Admin')||$user->is_super_admin==1;
        return view('user.create',compact('edited','form','admin'));
    }

    public function register(Request $request)
    {
        $id = $request->get('id');
        $auth=\Auth::user();
        $pwd=$this->_getGeneratePassword();
        $mes =[];
        // create new user
        if(!$id){

            $request['password']=$pwd;
            $request['password_confirmation']=$pwd;
            $this->validator($request->all())->validate();
            if(!$this->validateNumberRepresenter($request->get('roles'),$request->get('country'))){
                return redirect()->back()->withInput()->with(['error'=>"One Country cannot have Representer more than ".\Setting::get('LIMIT_REPRESENTER','1')]);
            }
            $user = $this->create($request->all());
            $user->assignRole($request->get('roles'));
            event(new Registered($user));
            if($this->_sendMailRegistered($request,$pwd)){
                $mes["warning"]="We met some problems during sending email to user";
            }
            $mes["info"]="The record was created.";
            return $this->registered($request, $user)
                        ?: redirect($this->redirectPath())->with($mes);
        }else{
//            add new user
            $this->admin=$auth->hasRole('Admin')||$auth->is_super_admin==1;
            $userInfor = $this->user->find($id);
            if($this->admin){
                if($request->get("country_id")!=$userInfor->country_id || !$userInfor->hasRole(ucwords($request->get("roles")))){
                    if(!$this->validateNumberRepresenter($request->get('roles'),$request->get('country_id'))){
                        return redirect()->back()->withInput()->with(['error'=>"One County cannot have Representer more than ".\Setting::get('LIMIT_REPRESENTER','1')]);
                    }
                }
                if(isset($userInfor)&&$userInfor->remember_token==null){
                    if($request['email']!=$userInfor->email){
                        if(!$this->_sendMailRegistered($request,$pwd)){
                            $mes['warning']= 'We met some problems during sending email to user';
                        }
                        $arr_edit=['username'=>$request['username'],'email'=>$request['email'],'category_id'=>$request['category_id'],'password'=>bcrypt($pwd) ];
                    }
                }
                $arr_edit=['username'=>$request['username'],'email'=>$request['email'],'country_id'=>$request['country_id'] ];
            }else{
                $arr_edit=['username'=>$request['username'],'email'=>$request['email']];
            }
            $this->validatorEdit($request->all())->validate();
            if(!$userInfor->hasRole($request->get('roles'))){
//                if($userInfor->hasRole('Representer') && $userInfor->children()->count()>0){
//                    return redirect()->back()->withInput()->withErrors(['error'=>'Representer  has many Candidate']);
//                }else{
//                    $userInfor->assignRole($request->get('roles'));
//                    $userInfor->removeRole('Representer');
//                }
                $old_role = $userInfor->hasRole('Representer')?"Representer":"Admin";
                $userInfor->removeRole($old_role);
                $userInfor->assignRole($request->get('roles'));

            }

            $userInfor->update($arr_edit);
            $mes['info']='The record was edited.';
            return redirect(route('user.index'))->with($mes);
        }
        return $this->registered($request, $userInfor)
                        ?: redirect($this->redirectPath())->with($mes);
        
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
            'roles'=>'required',
            'country'=>'required',
        ]);
    }

    protected function validatorEdit(array $data)
    {
        $id  =   Input::get('id', '');

        return Validator::make($data, [
            'username' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'country_id'=>'required',
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
            return User::create([
                        'username' => $data['username'],
                        'email' => $data['email'],
                        'password' => bcrypt($data['password']),
                        'country_id'=>$data['country'],
                        'active'=>'1',
//                        'parent_id'=>\Auth::id(),
                        'is_super_admin'=>0,
                    ]);

    }

    public function index()
    {
        return view('user.index');
        
    }
    
     public function getList()
    {
        $user = $this->user->makeModel()
//            ->where('parent_id','=',null)
            ->where('is_super_admin','!=','1')
//            ->whereIn()
//            $request->user()->hasAnyRole(Role::whereIn('name', ['Moderator', 'Gamemaster', 'Developer', 'Manager'])->get())
            ->whereHas('roles',function($q){ $q->whereIn("name", ["Admin","Representer","Reviewer"]); }) // not candidate
            ->orderBy('username', 'asc')->get();

        if(! \Auth::user()->is_super_admin){
            $user=$user->where('id','!=',\Auth::id());
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
            ->addColumn('role', function ($user) {
                // $role=$user->roles[0]->name=="Judge"?$user->roles[1]->name:$user->roles[0]->name;
                //     return count($user->roles)>0?$role:"";
                    $roles=$user->roles;
                    $res ="";
                    foreach ($roles as $k=> $role){
                        if($k>0){
                            $res.=",";
                        }
                        $res.=$role->name;
                    }
                    return $res;
//                    return count($user->roles)>0?$user->roles[0]->name:"";
                })
            ->addColumn('country',function($user){
                return $user->country?$user->country->name:"Cambodia";
            })
            ->addColumn('action', function ($user) {
                    $result = '<a href="'.route('user.edit', $user->id).
                    '" class="btn btn-icon btn-primary btn-xs m-b-3" title="Edit" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>';
                    
                    
                    $result .= '<a onclick="javascript:clickDestroy(this); return false;" data-item="'.$user->id.'" href="'.route('user.destroy', $user->id).'" class="sw-delete btn btn-icon btn-danger btn-xs m-b-3" title="Delete" ><i class="fa fa-trash-o"></i></a>';
                    return $result;
                })
            ->make(true);
    }

    public function edit(FormBuilder $formBuilder,$id)
    {
        $is_edit_profile = false;
        $this->admin=\Auth::user()->is_super_admin||\Auth::user()->hasRole('Admin');
        if($id==\Auth::id()){
            $userInfor = $this->user->find(\Auth::id());
            $url=route('user.editprofile');
            $is_edit_profile=true;
        }else  if($this->admin){
            $userInfor = $this->user->find($id);
            $url=route('register');
        }else{
            $userInfor = $this->user->find(\Auth::id());  
            $url=route('user.editprofile');
        }
        $userEdit=$userInfor->toArray();
        $userEdit['roles']=isset($userInfor->roles[0])?$userInfor->roles[0]->name:"";
        if(\Auth::user()->is_super_admin==1 && \Auth::id()==$id){
            $userEdit['country_id']=2;
        }
        $form = $formBuilder->create(UserForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  $url,
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'novalidate'=>  'novalidate',
                'model'     =>  $userEdit
            ]
        );
        $form->remove('password');
        $form->remove('password_confirmation');

        if(\Auth::user()->is_super_admin==1||\Auth::user()->hasPermissionTo('edit-user')){
            $form->modify('country_id','select');
        }else{
            $form->remove('country_id', 'select', [
                'attr' => ['disabled' => 'disabled']
            ]);
            $form->remove('roles');
        }

//        dd($form->getFields());
        if($is_edit_profile){// edit profile
            if($form->has('roles')){
                $form->remove('roles');
            }
            if(\Auth::user()->is_super_admin==1){
//                $form->remove('roles');
//                $form->remove('country_id');
            }
//            $form->modify('roles','select',['attr'=>['disabled'=>true ]]);

        }



        if(!$userInfor->hasRole('Candidate')){
            $form->remove('category_id');
        }else if($is_edit_profile){
            $form->modify('category_id','select',['selected'=>$userInfor->candidateCategory()->id,'attr'=>['disabled'=>true ]]);
        }
        
        $form->remove('country');
        $edited = true;
        $admin=$this->admin;
        return view($is_edit_profile?'user.edit_profile':'user.create', compact('form','edited','admin','is_edit_profile'));

    }

    public function profile(FormBuilder $formBuilder)
    {

        $cats=[];
        $cate=\Auth::user()->category_id;
        $userInfor = $this->user->find(\Auth::id());
//        if($userInfor->hasRole('Candidate')){
//            $userInfor->category_id=$userInfor->candidateCategory()->category_id;
//        }

        $form = $formBuilder->create(ProfileForm::class,
            [
                'method'    =>  'GET',
                'url'       =>  '#',
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                //'novalidate'=>  'novalidate',
                'model'     =>  $userInfor
            ]
        );
        if(!\Auth::user()->hasRole('Candidate')){
            $form->remove('category_id');
        }else{
            $form->modify('category_id','select',['selected'=>$userInfor->candidateCategory()->id]);
        }

        if(!(\Auth::user()->hasPermissionTo('edit-user')||\Auth::user()->is_super_admin==1)){
            $form->remove('country_id');
        }
        $form->disableFields();
        return view('user.profile', compact('form','cats'));

    }
    /*
     * save edit
     */
    public function editProfile(Request $request)
    {
            if((\Auth::user()->hasPermissionTo('edit-user')||\Auth::user()->is_super_admin==1) ){
                $arr_edit=['username'=>$request['username'],'email'=>$request['email'],'country_id'=>$request['country_id']];
            }else{
                $arr_edit=['username'=>$request['username'],'email'=>$request['email'],'country_id'=>\Auth::user()->country_id];
            }
//            dd('save edit');
//            if(\Auth::user()->hasRile('Candidate')){
//                unset($a)
//            }
            $this->validatorEdit($arr_edit)->validate();
            $userInfor = $this->user->find(\Auth::id());
            $userInfor->update($arr_edit);
//            @todo: user may change disaable on fronent
            flash()->info(lang('The record was edited.')); 
            return redirect(route('user.profile'))->with(['info'=>'The record was edited.']);
    }

    public function postDelete()
    {
        $id_item = Input::get('item');
        if($id_item){
            $user=$this->user->find($id_item);
            $is_admin = \Auth::user()->is_super_admin ==1 || \Auth::user()->hasRole('Admin');
            if(!$user){
                return json_encode(['error'=>1,'mess'=>"User not Found!!"]);
            }
            if($user->children()->count()>0 && !$is_admin){
                return json_encode(['error'=>1,'mess'=>"This user has create many users, Contact System Admin to delete!!"]);
            }
            if($user->hasAnyRole(["Judge","Final Judge"])&& !$is_admin ){
                return json_encode(['error'=>1,'mess'=>"This user may be also Judge or Final Judge, Contact System Admin to delete!!"]);
            }
            if($user->application){
                $user->application->delete();
            }
            $user->children()->update(['parent_id'=>null]);
            if($user->categories && $user->categories()->count()>0){
                $user->categories()->detach();
            }
            return $user->delete()? "success":"failed";
        }
        return "failed";
    }

    public function password(FormBuilder $formBuilder){
        $form = $formBuilder->create(PasswordForm::class,[
                'method'    =>  'POST',
                'url'       =>  route('user.changepassword'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'validate'=>  'validate'
            ]);
        return view('user.password',compact('form'));
    }
    public function changepassword(Request $request){
        if (\Hash::check($request->old_password, \Auth::user()->password)) {
            $pass_len=\Settings::get("MIN_PWD",6);
            $mes=[];
            if(strlen($request->new_password)>=$pass_len){
                if($request->new_password===$request->password_confirmation){
                    \Auth::user()->update(['password'=>bcrypt($request->new_password)]);
//                    flash()->info(lang('Password has been change!'));
                    return redirect(route('user.profile'))->with(['info'=>'Password has been change!']);
                }else{
//                    flash()->error(lang('Password does not match.'));
                    return redirect()->back()->with(['error'=>'Password does not match.']);
                }
            }else{
//                flash()->error(lang('New Password must be more than 6.'));
                return redirect()->back()->withInput()->withErrors(['error'=>"New Password must be more than $pass_len ."]);
            }
        }else{
//            flash()->error(lang('Password is not corrected'));
            return redirect()->back()->withInput()->withErrors(['error'=>'Password is not corrected']);
        }
        return redirect()->back()->withInput()->withErrors(['error'=>"error update password!!"]);
    }

    protected function validateNumberRepresenter($role, $country_id,$id=null){
//        @todo: not sure what the function does
        if($role=="Representer"){
            $limit = \Setting::get('LIMIT_REPRESENTER',1);
            $num = User::whereHas("roles", function($q){ $q->where("name", "Representer"); })->where('country_id',$country_id)->count();
            return $num<$limit;
        }else{
            return true;
        }
        
    }

    public function getListJson(Request $request){
        $user=[];
        $user[0] = []; 
        if($request->has('country_id')){
            $tmp = $this->user->makeModel()
                ->where('is_super_admin','!=','1')
//            ->where('parent_id','=',null)
                ->whereHas('roles',function($q){ $q->whereNotIn("name", ["Candidate","Reviewer"]); })
                ->where('country_id',$request->get('country_id')  )
                ->orderBy('username', 'asc')->get(['id', 'email AS text'])->toArray();
                $user=array_merge($user,$tmp);
        }
//
//

        return json_encode($user);
    }

}
