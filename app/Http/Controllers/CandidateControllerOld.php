<?php

// namespace App\Http\Controllers;

// use App\Entities\User;
// use App\Entities\Country;
// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Foundation\Auth\RegistersUsers;
// use Kris\LaravelFormBuilder\FormBuilder;
// use App\Forms\CandidateForm;
// use Illuminate\Auth\Events\Registered;
// use Illuminate\Support\Facades\Input;
// use App\Repositories\CandidateRepository;
// use App\Repositories\CategoryRepository;
// use App\Entities\CategoryUser;
// use function MongoDB\BSON\toJSON;
// use Yajra\DataTables\DataTables;

// class TestCandidateOldController extends Controller
// {

//     use RegistersUsers;

//     protected $redirectTo = '/candidate';

//     public function __construct(CandidateRepository $user,CategoryRepository $category)
//     {
//         $this->middleware('auth');
//         $this->idTable = (intval(Input::get('start')))+1;
//         $this->user=$user;
//         $this->category=$category;
//     }
//     public function showRegistrationForm(FormBuilder $formBuilder)
//     {
//         $user=\Auth::user();
//         $form = $formBuilder->create(CandidateForm::class,
//             [
//                 'method'    =>  'POST',
//                 'url'       =>  route('candidate.create'),
//                 'role'      =>  'form',
//                 'class'     =>  'form-horizontal',
//                 'enctype'   =>  'multipart/form-data',
//                 // 'novalidate'=>  'novalidate'
//             ]
//         );
//         $edited=false;
//         $isadmin=true;
// //        $form->remove('category_id') ;//@TODO: why remove?
//         if($user->is_super_admin!=1&&!$user->hasRole(ucwords('Admin'))){
//             $isadmin=false;
//             $form->remove('country_id');
//         }
//         return view('candidate.create',compact('edited','form','isadmin'));
//     }

//     public function register(Request $request)
//     {
//         $id = $request->get('id');
//         $auth=\Auth::user();
//         $reciever=$request->get('email');
//         $country_id=$request->has('country_id')?$request->get('country_id'):\Auth::user()->country_id;

//         // $reciever=$request->get('email');
//         $error_message=[];
//         $user=[];
//         if(!$id){
//             $pwd=str_random('8');
//             $request['password']=$pwd;
//             $request['password_confirmation']=$pwd;
//             $this->validator($request->all())->validate();

// <<<<<<< HEAD
//             if($this->detected($request->get('category'),\Auth::user()->country_id)){
//                 try{
//                     \Mail::send('mails.mailRegister', ['name' => $request->get('username'),'loginmail'=>$request->get('email'),'loginpwd'=>$pwd,'role'=>'Candidate','urlLink'=>route('login'),'sender'=>$auth->username], function ($message) use ($reciever,$auth)
//                     {
//                         $message->from(env('MAIL_USERNAME'), ucwords($auth->username));
//                         $message->to($reciever);
//                         $message->subject(lang('general.subject_register'));
//                     });
//                 }catch(\Exception $e){
//                     flash()->warning('We met some problems during sending email to user.');
//                 }

//                 flash()->info('Your data was created.');
//                 $user = $this->create($request->all());
//                 // dd($request->get("category"));
//                 $user->categories()->attach([$request->get('category'),[
//                     "country_id"=>$request->get('country'),
//                     "type"=>"candidate"]]);
//                 $user->assignRole('Candidate');
//                 event(new Registered($user));

// =======
//             if(\Setting::get("LIMIT_CAT_PER_CANDIDATE",1)>1){
// //                @todo : save multi Cat per Candidate
// >>>>>>> 90adbbee15d6e2a575ec4548c0d65a815e0d441c
//             }else{
//                 if($this->detectedLimitCandiatePerCountry($request->get('category_id'),$country_id)){
//                     try{
//                         \Mail::send('mails.mailRegister', ['name' => $request->get('username'),'loginmail'=>$request->get('email'),'loginpwd'=>$pwd,'role'=>'Candidate','urlLink'=>route('login'),'sender'=>$auth->username], function ($message) use ($reciever,$auth)
//                         {
//                             $message->from(env('MAIL_USERNAME'), ucwords($auth->username));
//                             $message->to($reciever);
//                             $message->subject(lang('general.subject_register'));
//                         });
//                     }catch(\Exception $e){
//                         $error_message['wanrning']='We met some problems during sending email to user';
//                     }
//                     $error_message['success']="Your data was created.";
//                     $user = $this->create($request->all());
//                     $user->categories()->attach(["category_id"=>$request->get('category_id')],["country_id"=>\Auth::user()->country_id ,'type'=>'candidate']);
//                     $user->assignRole('Candidate');
//                     event(new Registered($user));

//                 }else{
//                     return redirect()->back()
//                         ->withInput()
//                         ->with(['edited'=>false])->withErrors(['error'=>"Cannot create Candidate with category ".$this->category->find($request->get('category_id'))->name.' more than '. \Setting::get('LIMIT_CANDIDATE',3)]);
//                 }
//                 return $this->registered($request, $user)
//                     ?: redirect($this->redirectPath())->with($error_message);
//             }

//         }else{
// //            case edit
//             $this->admin=$auth->is_super_admin||$auth->hasRole('Admin')||$auth->hasRole('Representer');
//             $userInfor = $this->user->find($id);
//             if($this->admin){
//                 $arr_edit=['username'=>$request['username'],'email'=>$request['email'],'category_id'=>$request['category_id'],'country_id'=>$country_id ];
//             }else{
//                 $arr_edit=['username'=>$request['username'],'email'=>$request['email'] ];
//             }
//             $this->validatorEdit($request->all())->validate();
//             if($this->detectedLimitCandiatePerCountry($request->get('category_id'),$country_id)){
//                 if(isset($userInfor)&&$userInfor->remember_token==null){
//                     if($request['email']!=$userInfor->email){
//                         $pwd=str_random('8');
//                         try{
//                             \Mail::send('mails.mailRegister', ['name' => $request->get('username'),'loginmail'=>$request->get('email'),'loginpwd'=>$pwd,'role'=>'Candidate','urlLink'=>route('login'),'sender'=>$auth->username], function ($message) use ($reciever,$auth)
//                             {
//                                 $message->from(env('MAIL_USERNAME'), ucwords($auth->username));
//                                 $message->to($reciever);
//                                 $message->subject(lang('general.subject_register'));
//                             });
//                         }catch(\Exception $e){
//                             $error_message['wanrning']='We met some problems during sending email to user';
//                         }
//                         $arr_edit=['username'=>$request['username'],'email'=>$request['email'],'password'=>bcrypt($pwd) ];
//                     }
//                 }
// <<<<<<< HEAD
//                 $old_cate=$userInfor->categories[0]->id;
// =======
// >>>>>>> 90adbbee15d6e2a575ec4548c0d65a815e0d441c
//                 $userInfor->update($arr_edit);
//                 $userInfor->categories()->detach($old_cate);
//                 $userInfor->categories()->attach($request->get('category_id'),[
//                     "country_id"=>$request->get('country_id')],
//                     ["type"=>"candidate"]);
//                 $userInfor->syncRoles('Candidate');
//                 $userInfor->categories()->sync([$request['category_id']=>['country_id'=>$country_id,'type'=>'candidate']]);
//             }else{

//                 return redirect()->back()
//                             ->withInput()
//                             ->with(['edited'=>true])
//                             ->withErrors(['error'=>'Cannot change user category to '
//                                     .$this->category->find($request->get('category_id'))->name
//                                     .'. It is reach to limit '.\Setting::get('LIMIT_CANDIDATE',3).'.']);
//             }
//             return redirect(route('candidate.index'))->with($error_message);
//         }
        
//         return $this->registered($request, $user)
//                         ?: redirect($this->redirectPath());
        
//     }

//     /**
//      * Get a validator for an incoming registration request.
//      *
//      * @param  array  $data
//      * @return \Illuminate\Contracts\Validation\Validator
//      */
//     protected function validator(array $data)
//     {
//         return Validator::make($data, [
//             'username' => 'required|max:255',
//             'email' => 'required|email|max:255|unique:users',
//             'password' => 'required|min:6|confirmed',
//             'category_id'=>'required',
//         ]);
//     }

//     protected function validatorEdit(array $data)
//     {
//         $id  =   Input::get('id', '');
//         return Validator::make($data, [
//             'username' => 'required|max:255',
//             'email' => 'required|email|unique:users,email,'.$id,
//             'category_id'=>'required',
//         ]);
//     }



//     /**
//      * Create a new user instance after a valid registration.
//      *
//      * @param  array  $data
//      * @return User
//      */
//     protected function create(array $data)
//     {
//         $user=\Auth::user();
//         if($user->hasRole('Admin')||$user->is_super_admin==1){
//             return $this->user->create([
//                     'username' => $data['username'],
//                     'email' => $data['email'],
//                     'password' => bcrypt($data['password']),
//                     'active'=>'1',
//                     'is_super_admin'=>0,
//                     'parent_id'=>$user->id,
//                     'category_id'=>$data['category_id'],
//                     'country_id'=>$data['country_id'],
//                 ],['type'=>"candidate"]);
//         }else{
//             return $this->user->create([
//                     'username' => $data['username'],
//                     'email' => $data['email'],
//                     'password' => bcrypt($data['password']),
//                     'active'=>'1',
//                     'is_super_admin'=>0,
//                     'parent_id'=>$user->id,
//                     'category_id'=>$data['category_id'],
//                     'country_id'=>$user->country_id,
//                 ],['type'=>"candidate"]);
//         }

//     }

//     public function index()
//     {
//         return view('candidate.index');
//     }
    
//      public function getList()
//     {
// <<<<<<< HEAD
//         // $u=$this->user->find(7)->categories[0]->name;
//         // dd($u);
//         $user_id=\Auth::id();
//         if(\Auth::user()->is_super_admin==1||\Auth::user()->hasRole("Admin")){
//             $user = $this->user->makeModel()->where('parent_id','!=',null)->orderBy('username', 'asc')->get();
//         }else{
//             $user = $this->user->makeModel()->where('parent_id','=',$user_id)->orderBy('username', 'asc')->get();
//         }

        
// =======

//          if(\Auth::user()->hasRole('Representer')){
//              $user_id=\Auth::id();
// //             $user=$user->where('parent_id','=',$user_id);
//              $user = $this->user->makeModel()
//                  ->whereHas('roles',function($q){ $q->where("name", "Candidate"); })
//                  ->whereHas('categoryUsers',function($a){$a->where('country_id',\Auth::user()->country_id);})
//                  ->orderBy('username', 'asc')->get();
//         }else{
//              $user = $this->user->makeModel()
//                  ->whereHas('roles',function($q){ $q->where("name", "Candidate"); })
//                  ->orderBy('username', 'asc')->get();
//          }
// >>>>>>> 90adbbee15d6e2a575ec4548c0d65a815e0d441c
//         return Datatables::of($user)
//             ->addColumn('id',function ($user){
//                     return $this->idTable++;
//                 })
//             ->addColumn('name', function ($user) {
//                     return ucwords($user->username);
//                 })
//             ->addColumn('email', function ($user) {
//                     return ucwords($user->email);
//                 })
//             ->addColumn('category', function ($user) {
//                     return ucwords($user->categories[0]?$user->categories[0]->name:"");
//                 })
//             ->addColumn('country', function ($user) {
//                     return ucwords($user->countries[0]?$user->countries[0]->name:"");
//                 })
//             ->addColumn('action', function ($user) {
//                     $result="";
//                     if(\Auth::user()->is_super_admin==1||\Auth::user()->hasPermissionTo("edit-candidate")){
//                         $result .= '<a href="'.route('candidate.edit', $user->id).
//                         '" class="btn btn-icon btn-primary btn-xs m-b-3" title="Edit" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>';
//                     }
//                     if(\Auth::user()->is_super_admin==1||\Auth::user()->hasPermissionTo("delete-candidate")){
//                         $result .= '<a onclick="javascript:clickDestroy(this); return false;" data-item="'.$user->id.'" href="'.route('candidate.destroy', $user->id).'" class="sw-delete btn btn-icon btn-danger btn-xs m-b-3" title="Delete" ><i class="fa fa-trash-o"></i></a>';
//                     }
//                     return $result;
//                 })
//             ->make(true);
//     }

//     public function edit(FormBuilder $formBuilder,$id)
//     {
//         $userInfor = $this->user->find($id);
        
//         if(count($userInfor)<1){
//             return redirect(route('candidate.index'))->with(["error"=>"Request not found"]);
//         }
//         $category = $userInfor->categories[0]->id;
//         $userInfor['category_id']=$category;
//         $userInfor['country_id']=isset($userInfor->categoryUsers[0])?$userInfor['country_id']:$userInfor->categoryUsers[0]->country_id;
//         // dd($category);
//         $user=\Auth::user();
//         if(($userInfor->parent_id!=\Auth::id())&&($user->is_super_admin!=1)&&(!$user->hasRole(ucwords('Admin')))){
// //            flash()->warning("You have no permission.");
//             return redirect(route('candidate.index'))->with(['warning'=>"You have no permission."]);
//         }
        
//         $form = $formBuilder->create(CandidateForm::class,
//             [
//                 'method'    =>  'POST',
//                 'url'       =>  route('candidate.store'),
//                 'role'      =>  'form',
//                 'class'     =>  'form-horizontal',
//                 'enctype'   =>  'multipart/form-data',
//                 //'novalidate'=>  'novalidate',
//                 'model'     =>  $userInfor
//             ]
//         );
//         $isadmin=true;
//         if($user->is_super_admin!=1&&!$user->hasRole(ucwords('Admin'))){
//             $isadmin=false;
//             $form->remove('country_id');
//         }

//         $form->remove('password');
//         $form->remove('password_confirmation');
// //      $todo:
//         $form->remove('categories');
//         //$form->remove('admin');
//         $edited = true;
//         $admin=$userInfor;
//         return view('candidate.create', compact('form','edited','admin','isadmin'));
//     }

//     public function postDelete()
//     {
//         // todo: work for 1 user 1 application

//         $id_item = Input::get('item');
//         if($id_item){
//             $user=$this->user->find($id_item);
//             if($user && $user->hasRole('Candidate')){
//                 if($user->application){
//                     $user->application->delete();
//                 }
//                 $user->categories()->detach();
//                 return $user->delete()? "success":"failed";
//             }
//         }
        
//         return "failed";
//     }

//     public function getDelete($id_item)
//     {
//         // todo: work for 1 user 1 application
// //        $id_item = Input::get('item');
//         if($id_item){
//             $user=$this->user->find($id_item);
//             if($user && $user->hasRole('Candidate')){
//                 if($user->application){
//                     $user->application->delete();
//                 }
//                 $user->categories()->detach();
//                 $user->delete();
//                 return "success";
//             }
//         }

//         return "failed";
//     }


//     private function detectedLimitCandiatePerCountry($id_category,$id_country){
//         $num = CategoryUser::where('country_id',$id_country)->where('category_id',$id_category)->where('type','candidate')->count();
// //        dd($num);
//         return $num < \Setting::get('LIMIT_CANDIDATE','3');
//     }

//     private function detectEdit($user){
//         if(isset($user)&&count($user->application)==1){
            
//         }
//     }


// }