<?php namespace App\Http\Controllers;

use App\Entities\Category;
use App\Entities\Country;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
// use Validator;
use App\Repositories\ApplicationRepository;
use App\Repositories\UserRepository;
use App\Forms\ApplicationForm;
use Kris\LaravelFormBuilder\FormBuilder;
use PDF;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Repositories\JudgeRepository;
use Auth;

use Kris\LaravelFormBuilder\FormBuilderTrait;

class ApplicationController extends Controller {
    use FormBuilderTrait;
    private $application;
    public function __construct(UserRepository $user,ApplicationRepository $application,JudgeRepository $judge,CategoryRepository $category) {
        $this->user=$user;
        $this->application = $application;
        $this->category= $category;
        $this->idTable = 1;
        $this->judge=$judge;
        $this->started=Carbon::createFromFormat('m/d/Y H', \Setting::get('STARTED_JUDGEMENT_DATE').'0');
        $this->arr_draft=[];
//        $start_judge = Carbon::createFromFormat('m/d/Y', \Setting::get('DATELINE_SUBMIT_FORM_DATE','07/28/2019'));
        $this->is_deadline_sumbit_form = is_deadline();
    }
    public function create(FormBuilder $formBuilder){
        $applicationInfor =$this->application->firstOrCreate();
        $form = $formBuilder->create(ApplicationForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  route('application.store'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'id'=>'application',
                'novalidate'=>  'novalidate',
                'model'     =>  $applicationInfor,
            ]
        );
        $can_edite=true;
        $edited = false;
//        $deadline = \Setting::get('CLOSED_FORM_DATE');
        if($this->is_deadline_sumbit_form){
            $can_edite=false;
            $can_edite = false;
            $form->disableFields();
        }elseif (isset($applicationInfor) && ($applicationInfor->status=="finalize"  || $applicationInfor->status=="accepted" )) {
            $can_edite = false;
            $edited = false;
            $form->disableFields();
        }
        $video=false;
//        @TODO: check video
        if($applicationInfor->video()){
            $video=$applicationInfor->video();
            $edited=$video->path;
        }

        $comments = $applicationInfor->comments->whereNotIn('status',['reviewed','achieved']);
        return view('application.create', compact('form','edited','can_edite','comments','video'));
    }
    
    public function index()
    {
        $is_admin = \Auth::user()->is_super_admin==1||\Auth::user()->hasRole('Admin');
         $categories = $this->category->all(['id','name']);
        $categories = $categories->pluck('name','id');
        $countries = Country::all(['id','name'])->pluck('name','id');
//        dd($categories);
        return view('application.index',compact('categories','is_admin','countries'));
    }
    
    public function getList(Request $request)
    {
        $applications=[];
        $applications = $this->application->makeModel()->whereHas('user', function($u) use ($request){
            $u->whereHas('roles',function ($r) use ($request){
                $r->where('name','Candidate');
            })
             ->whereHas('candidateCategories',function ($c) use ($request){
                 $is_represen = \Auth::user()->hasRole('Representer');
                 if(\Auth::user()->hasRole('Representer') || ($request->has("country_id") && $request->get("country_id") !="" )){
                     $country_id= \Auth::user()->hasRole('Representer')!=true?$request->get("country_id"):\Auth::user()->country_id;
                     $c->where('country_id',$country_id);
                 }
                 if($request->has('category_id') && $request->get('category_id')!= ""){
                     $c->where('category_id',$request->get('category_id'));
                 }

             });
        });
        /*
        if(\Auth::user()->is_super_admin==1||\Auth::user()->hasRole('Admin')){
//            $applications = $this->application->makeModel()->orderBy('id', 'asc')->get();
            $applications = $this->application->makeModel()->whereHas('user', function($u){$u->whereHas('roles',function ($r){
                $r->where('name','Candidate');

            });});
        }elseif(\Auth::user()->hasRole('Representer')){
            $applications = $this->application->makeModel()->whereHas('user', function($u){
                $u->whereHas('roles',function ($r){
                     $r->where('name','Candidate');
                })
                -> where('country_id',\Auth::user()->country_id);
//                ->whereHas('categoryUsers',function ($cu){
//                    $cu->where('country_id',\Auth::user()->country_id);
//                });
                });
        }
// */
//        if ($request->has('category_id') && $request->get('category_id')!="") {
//            $applications= $applications->whereHas('user', function($u) use ($request){
//                    $u->whereHas('candidateCategories',function ($c) use ($request){
////                        $c->where('id',$request->get('category_id'));
//                    });
//            });
//        }

        $status = $request->get('status','draft');

        if('draft'== $status){
            $applications = $applications->where('status','!=','accepted');
        }else{
            $applications = $applications->where('status','accepted');
        }

//        $is_show_accepted = \Settings::get('IS_HIDE_APP_ACCEPTED',true);
//        if($is_show_accepted){
//            $applications = $applications->where('status','!=','accepted');
//        }
        $applications=$applications->get();
            $is_deadline=$this->is_deadline_sumbit_form;
            return Datatables::of($applications)
//                ->filter(function ($instance) use ($request) {
//                    if ($request->has('status')) {
//                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
//                            return $request->get('status')==""?true :$request->get('status')==$row['status'] ? true :false;
//                        });
//                    }
//                    if ($request->has('coun')) {
//                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
//                            return $request->get('coun')==""?true :$request->get('coun')==$row['country_id'] ? true :false;
//                        });
//                    }
//
//                })
                ->addColumn('id',function ($application){
                        return $this->idTable++;
                    })
                ->addColumn('product', function ($application) {
                        return ucwords($application->product_name);
                    })
                ->addColumn('applicant', function ($application) {
                        return ucwords($application->user->username);
                    })
                ->addColumn('category', function ($application) {
//                    return "";
                        return ucwords($application->user->candidateCategory()?$application->user->candidateCategory()->name:"");
                    })
                ->addColumn('country', function ($application) {
//                    return "";
                        return ucwords($application->user->country?$application->user->country->name:"");
                    })
                ->addColumn('status',function($application){
                        return ucwords($application->status);
                    })
                ->addColumn('action', function ($application) use ($is_deadline) {
                        $result='';
                        $result .= '<a href="'.route('application.view', $application->id).
                        '" class="btn btn-icon btn-primary btn-xs m-b-3" title="Review" style="margin-right: 5px;"><i class="fa fa-list"></i></a>';
                        $result .= ($application->video()!=null )?'<a href="'.route('video.player', $application->video()->id).
                        '" class="btn btn-icon btn-danger btn-xs m-b-3" title="Video" style="margin-right: 5px;"><i class="fa fa-youtube-play"></i></a>':"";
                       if(!$is_deadline &&  in_array($application->status,['finalize','comment'])) {
                           $result .= '<a onclick="javascript:alertAccept(this); return false;" data-item="' . $application->id . '" href="' . route('application.accept', $application->id) . '" class="sw-delete btn btn-icon btn-success btn-xs m-b-3" title="Accept" ><i class="fa fa-check"></i></a>';
                       }
                        return $result;
                    })
                ->make(true);
        
    }
    
    public function store(FormBuilder $formBuilder , Request $request)
    {

        $id = $request->get('id',null);

        if($this->is_deadline_sumbit_form){
//            flash()->warning('You cannot edit your application ');
            return redirect()->back()->with(['info',"Deadline of application submission!!!\n You Cannot edit your application "]);
        }
//        TODO : check if status final
//        elseif (isset($applicationInfor) && $applicationInfor->status=="finalize") {
//            flash()->warning('You make your application so you cannot edit it !!!');
//            return redirect()->back();
//        }
        $form = $formBuilder->create(ApplicationForm::class);
        $data = $request->all();
        if(isset($request->action) && $request->action =='final'){

            if(!$form->isValid()){
                $messages = "";
//                foreach ($form->getErrors() as $fiel=> $error){
//                    $messages=$messages.$error[0].'<br>';
//                }
//                flash()->warning($messages);
                return redirect()->back()->withErrors($form->getErrors())->withInput();
            }
            $old = $this->application->find($id);
            if(!$old || !$old->video() || !$old->video()->path){
                return redirect()->back()->withErrors("please upload Video ")->withInput();
            }
            $data['status']= 'finalize';
        }
        if($request->hasFile('video_demo')){
            $file = Input::file('video_demo');
            $tmpFilePath = '/video/demos/';
            $tmpFileName = time()  . $id.'.'.$file->getClientOriginalExtension();
            $file = $file->move(public_path() .$tmpFilePath, $tmpFileName);
            $path = $tmpFilePath . $tmpFileName;
            $data = ($request->except(['video_demo']));
            $data['video_demo'] = ''.$path;
        }
        if(!$id){
            $applicationInfor=$this->application->create($data);
            $id=$applicationInfor->id;
        }else{
            $applicationInfor = $this->application->find($id);
            $applicationInfor->update($data);
        }
//        flash()->info('Your data was saved.');
//        return redirect(route('application.edit',$id));
        return redirect(route('application.create'))->with(['info'=>'Your data was saved.']);
    }

    public function draft(FormBuilder $formBuilder , Request $request)
    {
        $isEdite=false;
        $id = $request->get('id');
        $form = $formBuilder->create(ApplicationForm::class);
        $data = $request->all();

        if(!$id){
            $applicationInfor =$this->application->create($data);
            $id=$applicationInfor->id;
        }else{
            $applicationInfor = $this->application->find($id);
            $applicationInfor->update($data);
        }

        return response()->json(['id'=>$id, 'datas'=>$data],200);
    }

    public function postDelete()
    {
        $id_item = Input::get('item');
        if($id_item){
            $this->application->delete($id_item);
            return "success";
        }
        return "failed";
    }

    public function edit(FormBuilder $formBuilder,$id)
    {
        $applicationInfor = $this->application->find($id);
        $form = $formBuilder->create(ApplicationForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  route('application.store'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'novalidate'=>  'novalidate',
                'model'     =>  $applicationInfor
            ]
        );
        $can_edite=true;
        if (empty($applicationInfor)):
            return redirect()->route('application.index')->withErrors(['error'=>'The record not found.']);
        endif;
        $edited = $applicationInfor->video_demo;
        $comments = $applicationInfor->comments->whereNotIn('status',['reviewed','achieved']);
        return view('application.create', compact('form','edited','can_edite','comments'));
    }

    public function review(FormBuilder $formBuilder,$id)
    {
        $applicationInfor = $this->application->find($id);
        $form = $formBuilder->create(ApplicationForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  '#',
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'novalidate'=>  'novalidate',
                'model'     =>  $applicationInfor
            ]
        );
        $form->disableFields();
        $can_edite=true;
        if (empty($applicationInfor)):
            flash()->error(lang('The record not found.'));
            return redirect(route('application.index'));
        endif;
        $edited = $applicationInfor->video_demo;
        return view('application.create', compact('form','edited','can_edite'));
    }

    public function accept(FormBuilder $formBuilder, Request $request)
    {
        $id_item = Input::get('item');
        $auth=\Auth::user();
        $is_admin = $auth->is_super_admin ==1 ;//|| $auth->hasRole('Admin')  ;
        if($this->is_deadline_sumbit_form && !$is_admin){
            return json_encode(['error'=>1,'mess'=>"It's deadline !!"]);
        }
        if(!$id_item){
            return json_encode(['error'=>1,'mess'=>"Application Not found !!"]);
        }
        $application = $this->application->find($id_item);
        $form = $formBuilder->create(ApplicationForm::class);
        $request->merge($application->toArray());
        $form->setRequest($request);
        if (!$form->isValid() ) {
            return json_encode(['error'=>1,'mess'=>"Many information are missing !!"]);
        }else if(!$application->video()){
            return json_encode(['error'=>1,'mess'=>"The application is missing video demo!!"]);
        }
        $candidate=$application->user;
        if(!$candidate || !$candidate->hasRole("Candidate")){
//                $is_roled=$this->user->find($application->user->parent_id);
            return json_encode(['error'=>1,'mess'=>"It isn't the candidate form!!"]);
        }

        $application->update(['status'=>'accepted']);
        try {

            \Mail::send('mails.sendingAcceptForm', ['name' => $candidate->username, 'urlLink' => route('application.create'), 'sender' => $auth->username], function ($message) use ($auth, $candidate) {
                $message->from($auth->email, ucwords($auth->username));
                $message->to($candidate->email);
                $message->subject(lang('general.subject_accpet'));
            });
        }catch(\Exception $e){

        }
        return "success";

    }



    public function pdfview(Request $request,$id)
    {
        $application = $this->application->find($id);
        $categories = Category::select('id','name','abbreviation')->orderBy('id')->get();
        $pdf = PDF::loadView('application.pdfview',compact('application','categories'));
        if($request->has('download')){
            return $pdf->download('AICTA_2017_entry_form.pdf');
        }
        return $pdf->stream();
//        return view('application.pdfview');
    }


    public function video($filename='')
    {
        //$videosDir = base_path('resources/assets/videos');
        $videosDir = base_path('public');
        if (file_exists($filePath = $videosDir."/".$filename)) {
            $stream = new \App\Http\VideoStream($filePath);
            return response()->stream(function() use ($stream) {
                $stream->start();
            });
        }
        return response("File doesn't exists", 404);
    }

    public function view(FormBuilder $formBuilder,$id)
    {
        $can_comment=true;
        $applicationInfor = $this->application->find($id);
        $form = $formBuilder->create(ApplicationForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  route('application.store'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'novalidate'=>  'novalidate',
                'model'     =>  $applicationInfor
            ]
        );
        if($this->is_deadline_sumbit_form){
            $can_comment=false;
        }
//        $comments = $applicationInfor->comments->whereNotIn('status',['reviewed','achieved'])->orderByDesc('comments.created_at');
        $comments = $applicationInfor->comments->whereNotIn('status',['reviewed','achieved']);
        $form->disableFields();
        $can_edite=false;

        if (empty($applicationInfor)):
//            flash()->error(lang('The record not found.'));
            return redirect(route('application.index'))->withErrors(['The record not found.']);
        endif;
        $edited=null;
        $video=null;
        if($applicationInfor->video()){
            $video=$applicationInfor->video();
            $edited=$video->path;
        }
//        $edited = $applicationInfor->video_demo;
        return view('application.view', compact('form','edited','can_edite','comments','can_comment','video'));
    }

}



