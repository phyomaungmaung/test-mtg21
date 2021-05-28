<?php namespace App\Http\Controllers;

use App\Entities\Category;
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
use Illuminate\Support\Facades\Validator;
use App\Repositories\CategoryRepository;
use App\Entities\Country as Country;
use App\Repositories\ResultRepository;
class OnlineJudgingController extends Controller {

	private $application;

    public function __construct(CategoryRepository $category,UserRepository $user,Country $country,ApplicationRepository $application,JudgeRepository $judge)
    {
        $this->started=Carbon::createFromFormat('m/d/Y H', \Setting::get('STARTED_JUDGEMENT_DATE').'0');
        $this->ended = Carbon::createFromFormat('m/d/Y H', \Setting::get('ENDED_JUDGEMENT_DATE').'0');
        $this->middleware('auth');
        $this->idTable = 1;
        $this->user=$user;
        $this->category=$category;
        $this->country=$country;
        $this->application=$application;
        $this->judge=$judge;
    }


	public function aseanApplication()
    { 
        if(Carbon::now()->lt($this->started) && \Auth::user()->is_super_admin!=1){
            $msg="All applications may be not ready for judge. Please check back on: <b>".$this->started->toFormattedDateString()."</b>";
            $type="red";
            return redirect()->route('judge.message')->with(['type'=>$type,'msg'=>$msg]);
            // return view('layouts.message',compact('msg','type'));
        }

        return view('application.aseanlist');
    }

    public function judgeMessage()
    { 
        return view('layouts.message');
    }

	public function getAseanList()
    { 
        if(Carbon::now()->lt($this->started) && \Auth::user()->is_super_admin!=1 ){
            $msg="All applications may be not ready for judge,or the deadline have arrived. Please check back on: <b>".$this->started->toFormattedDateString()."</b>";
            return Datatables::of([])->make();
        }
        $auth=\Auth::user();
        $application=[];
        $judged_id=[];

        if($auth->hasRole('Judge')){
            $judged_id=$this->judge->makeModel()->where('user_id',$auth->id)->where('status','1')->where('type','semi')->pluck('app_id')->toArray();
            $pre_app = $this->application->makeModel()->where('status','=','accepted')->whereNotIn('id',$judged_id)->orderBy('id', 'asc')->get();
            $usercate=$this->user->find($auth->id)->categories;
            $cate_id=[];
            if(isset($usercate)){
                foreach ($usercate as $key => $value) {
                    if($value->pivot->type=="semi")
                        $cate_id[]=$value->id;
                }
            }

            foreach ($pre_app as $key => $app) {
                $app_user_cate=[];
                $appuser=$app->user;
                if($appuser&&$appuser->categories){
                    foreach ($appuser->categories as $appcate) {
                        $app_user_cate[]=$appcate->id;
                    }

                    if(sizeof($app_user_cate)>0&&!array_diff($app_user_cate, $cate_id)){
                         $application[]=$app;
                    }
                }
            }
            
        }else{
            $judged_id=$this->judge->makeModel()->where('status','1')->where('type','semi')->pluck('app_id')->toArray();

            $pre_app = $this->application->makeModel()->where('status','=','accepted')->whereNotIn('id',$judged_id)->orderBy('id', 'asc')->get();
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
            ->addColumn('category', function ($application) {
            	$cate="";
            	// dd($application->user->categories[0]->name);
            	if($application->user&&sizeof($application->user->categories)>0){
            		$cate=$application->user->categories[0]->name;
            	}
                return ucwords($cate);
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
                $result .= '<a href="'.route('application.aseanview', $application->id).
                    '" class="btn btn-icon btn-primary btn-xs m-b-3" title="Review" style="margin-right: 5px;"><i class="fa fa-list"></i></a>';
                $result .= '<a href="'.route('video.player', $application->video()->id).
                    '" class="btn btn-icon btn-danger btn-xs m-b-3" title="Video" style="margin-right: 5px;"><i class="fa fa-youtube-play"></i></a>';
                if(Auth::user()->hasRole('Judge')){
                    $result .= '<a href="'.route('judge.score', $application->id).
                        '" class="btn btn-icon btn-success btn-xs m-b-3" title="Judge" style="margin-right: 5px;"><i class="fa fa-gavel"></i></a>';
                }
                return $result;
            })
            ->make(true);


    }

    public function getJudgedList()
    {
        if(Carbon::now()->lt($this->started) && \Auth::user()->is_super_admin!=1 ){
            $msg="All applications may be not ready for judge,or the deadline have arrived. Please check back on: <b>".$this->started->toFormattedDateString()."</b>";
            return Datatables::of([])->make();
        }

        $auth=\Auth::user();
        $application=[];
        $judged_id=[];
        if($auth->hasRole('Judge')){
             $semiJudges=$this->judge->makeModel()->where('user_id',$auth->id)->where('status','1')->where('type','semi')->get();
            $judged_id= $semiJudges ->pluck('app_id')->toArray();
            $pre_app = $this->application->makeModel()->where('status','=','accepted')->whereIn('id',$judged_id)->orderBy('id', 'asc')->get();
            $usercate=$this->user->find($auth->id)->categories;
            $cate_id=[];
            if(isset($usercate)){
                foreach ($usercate as $key => $value) {
                    $cate_id[]=$value->id;
                }
            }
            foreach ($pre_app as $key => $app) {
                if(in_array($app->user->categories[0]->id, $cate_id)){
                    $tmp=$semiJudges->where('app_id',$app->id)->first();
                    try{
                        $app->score=$tmp->total;
                    }catch (\Exception $e){
                        $app->score = isset($tmp) && isset($tmp->total) ?$tmp->total:0;
                    }
                    $application[]=$app;
                }
            }
        }else{
            $judged_id=$this->judge->makeModel()->where('status','1')->where('type','semi')->pluck('app_id')->toArray();
            $pre_app = $this->application->makeModel()->where('status','=','accepted')->whereIn('id',$judged_id)->orderBy('id', 'asc')->get();
            $application=$pre_app;
        }

        //dd($application[0]->user->username);
        return Datatables::of($application)
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
                return ucwords($application->user->categories?$application->user->categories[0]->name:"");
            })
            ->addColumn('country', function ($application) {
                return ucwords($application->user->country?$application->user->country->name:"");
            })
            ->addColumn('score', function ($application) {
                return isset($application->score)?$application->score:0;
            })
            ->addColumn('action', function ($application) {
                $result='';
                $result .= '<a href="'.route('application.aseanview', $application->id).
                    '" class="btn btn-icon btn-primary btn-xs m-b-3" title="Review" style="margin-right: 5px;"><i class="fa fa-list"></i></a>';
                $result .= '<a href="'.route('video.player', $application->video()->id).
                    '" class="btn btn-icon btn-danger btn-xs m-b-3" title="Video" style="margin-right: 5px;"><i class="fa fa-youtube-play"></i></a>';
                if(Auth::user()->hasRole('Judge')){
                    $result .= '<a href="'.route('judge.score', $application->id).
                        '" class="btn btn-icon btn-success btn-xs m-b-3" title="Rejudge" style="margin-right: 5px;"><i class="fa fa-gavel"></i></a>';
                }elseif(Auth::user()->hasRole('Admin')||Auth::user()->is_super_admin==1){
                    $num=$this->judge->makeModel()->where('app_id',$application->id)->where('status','1')->where('type','semi')->count();
                    $result .= '<div '.
                        '" class="btn btn-icon btn-success btn-xs m-b-3" title="Judge" style="margin-right: 5px;"><i class="">'.$num.'</i></div>';
                }
                return $result;
            })
            ->make(true);
    }

    public function aseanview(FormBuilder $formBuilder,$id)
    {
        $can_comment=false;
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
        if(is_deadline()){
            $can_comment=false;
        }
//        $comments = $applicationInfor->comments->whereNotIn('status',['reviewed','achieved'])->orderByDesc('comments.created_at');
        $comments = $applicationInfor->comments->whereNotIn('status',['reviewed','achieved']);
        $form->disableFields();
        $can_edite=false;

        if (empty($applicationInfor)):

            return redirect()->back()->withErrors(['error'=>"The record not found."]);
        endif;
        $video=null;
        $edited=false;
        if($applicationInfor->video()){
            $video=$applicationInfor->video();
            $edited=trim($video->path,"/");
        }
        return view('application.view', compact('form','edited','can_edite','comments','can_comment','video'));
    }

    public function judging($id){
        $auth=\Auth::user();
        $condition=true;
        if(Carbon::now()->lt($this->started)){
            $msg="List of application form to be judged will be displayed on : <b>".$this->started->toFormattedDateString()."</b>";
            $type="red";
            return redirect()->route('judge.message')->with(['type'=>$type,'info'=>$msg]);
        }

        $end_judge=$this->ended;
        
        if(Carbon::now()->gt($end_judge->addDay())){
            $condition=false;  
        }
        
        $app=$this->application->find($id);

        if(!$auth->hasRole('Judge')){
            if(!$auth->is_super_admin){
                flash()->error(lang('Sorry, you have no permission!')); 
                return redirect(route('application.aseanapp'));
            }
        }else{
            $cate_id=$auth->categories->pluck('id')->toArray();
            // dd($cate_id);
            if(!in_array($app->user->categories[0]->id, $cate_id)){
                flash()->error(lang('Sorry, you have no permission!')); 
                return redirect()->route('application.aseanapp');
            }
        }
        
        $user=$this->user->find($app->user_id);
        $cate=$user->categories[0]->name;
        $user_id=\Auth::id();
        $form=$this->judge->makeModel()->where('app_id',$id)->where('type','semi')->where('user_id',$user_id)->first();

        $can_edit=true;
        if(Carbon::now()->gt($end_judge)) 
        {
            $can_edit=false;
        }
        if($app){
            $video = $app->video()->youtube_id;
            $mime = "";
            $title = $app->product_name;
            $is_youtube=true;
            if(empty($video)){
                $video = $app->video()->path;
                $mime= $app->video()->mine_type;
                $is_youtube=false;
            }
            return view('judge.judge')->with(compact('video', 'mime', 'title','cate','form','id','is_youtube','can_edit'));
        }
         return redirect()->back();
        
    }

    public function saveScore(Request $request,$id)
    {
        $condition=true;

        if(Carbon::now()->lt($this->started)){
            $msg="List of application form to be judged will be displayed on : <b>".$this->started->toFormattedDateString()."</b>";
            $type="red";
            return redirect()->route('judge.message')->with(['type'=>$type,'info'=>$msg]);
        }

        $end_judge=$this->ended;
        
        if(Carbon::now()->gt($end_judge->addDay())){
            $msg="We are sorry, the online judging is closed due to the deadline since : <b>".$end_judge->toFormattedDateString()."</b>";
            $type="red";
            return redirect()->route('judge.message')->with(['type'=>$type,'info'=>$msg]);
        }
        
        
        if(Carbon::now()->gt($end_judge)){
            $condition=false;  
        } 

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
        $cate_name=$app->user->categories[0]->name;
        $va=$this->validatorScore($data,$cate_name);
        
        if(!$app){
            // flash()->error(); 
            return redirect()->back()->withInput()->with(['success'=>lang('Form Application does not found')]);
        }else if($va->fails()){
            $msg='Please check your given score. It must be between 1 and 10.'; 
            return redirect()->back()->withErrors($va)->withInput()->with(['error'=>$msg]);
        }else{

            $cate=$app->user->categories[0]->id;
            $user_id=\Auth::id();
            $form=$this->judge->makeModel()->where('app_id',$id)->where('user_id',$user_id)->first();

            if(Carbon::now()->gt($end_judge)){
                //  $msg;
                // $type="red";
                // return view('layouts.message',compact('msg','type'));
                $msg="We are sorry, the online judging is closed due to the deadline since : <b>".$this->ended->toFormattedDateString()."</b>"; 
                    return redirect(route('application.aseanapp'))->with(['success'=>$msg]);
            }

            $data['app_id']=$id;
            $data['category_id']=$cate;
            $data['user_id']=$user_id;
            $data['type']='semi';
            // $cate_name=$app->user->categories[0]->name;
            $total=0;
            $data['status']=1;
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
            $change_cate_num=$this->category->find($cate); 
            $cate_user=$user->categories;
            $numberform=0;
            if(isset($cate_user)){
                foreach($cate_user as $key => $valcate) {
                    if($valcate->pivot->type=='semi'&&$valcate->pivot->category_id==$cate){
                        $numberform=$valcate->pivot->num_form;
                        break;
                    }
                }
            }
            if($form ){
                $sav=$form->update($data);
                $change_cate_num->users()->updateExistingPivot($user_id,['num_form'=>$numberform],false);

                if($sav){
                    $msg=lang('Application Form has been save successfully. It is moved to tab Judging Completed. We will consider this judgement later.'); 
                    return redirect(route('application.aseanapp'))->with(['success'=>$msg]);
                }

                return redirect(route('application.aseanapp'))->with(['error'=>'Something occure unexpected']);
            }else{
                $sav=$this->judge->create($data);
                if($sav){
                    $numberform=$numberform+1;
                    $fcate=$this->category->find($cate);
                    $fcate->users()->updateExistingPivot($user_id,['num_form'=>$numberform],false);
                    $msg=lang('Application Form has been updated successfully. It is moved to tab Judging Completed. We will consider this judgement later.');
                        flash()->success(lang('Application Form has been updated successfully. It is moved to tab Judging Completed. We will consider this judgement later.'));
                    return redirect(route('application.aseanapp'))->with(['success'=>$msg]);
                }else{
                    flash()->error(lang('Some error occure during process.')); 
                    return redirect()->back()->withInput();
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
}