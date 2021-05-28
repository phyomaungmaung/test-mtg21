<?php

namespace App\Http\Controllers;

use App\Entities\Category;
use App\Entities\FinalJudge;
use App\Entities\User;
use App\Entities\Result;
use App\Repositories\CountryRepository;
use App\Repositories\ResultRepository;
use Illuminate\Http\Request;

use App\Repositories\UserRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ApplicationRepository;
use App\Repositories\JudgeRepository;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;


class ResultController extends Controller
{
    // use RegistersUsers;

    protected $redirectTo = '/result';

    public function __construct(CategoryRepository $category,UserRepository $user,ResultRepository $result,CountryRepository $country,ApplicationRepository $application,JudgeRepository $judge)
    {
        $this->started=Carbon::createFromFormat('m/d/Y H', \Setting::get('ENDED_JUDGEMENT_DATE').'0');
        $this->semiFinalDate=Carbon::createFromFormat('m/d/Y', \Setting::get('ONLINE_JUDGE_RESULT_DATE','05/07/2019'));
        $this->middleware('auth');
        $this->idTable = 1;
        $this->rank= 0 ;
        $this->user=$user;
        $this->category=$category;
        $this->country=$country;
        $this->application=$application;
        $this->judge=$judge;
        $this->result=$result;
        $this->prices = ['Gold','silver','Brown','','',''];
    }

    public function index(){
        $auth = \Auth::user();
        $is_admin = $auth->is_super_admin == 1 || \Auth::user()->hasRole('Admin');
        if(!is_deadline($this->semiFinalDate) && !$is_admin){
            $msg="Result are not available now Please try again later!! ";
            $type="red";
            $title = "Result Message";
            return view('layouts.message',compact('type','msg','title'))->with(['type'=>$type,'msg'=>$msg]);
//            return redirect()->route('judge.message')->with(['type'=>$type,'msg'=>$msg]);
        }
        $countries = $this->country->all();
        $industries= $countries->whereIn('name',array_values(\Settings::get('industries',[])))->sortBy('name')->values();
        $countries= $countries->whereNotIn('name',array_values(\Settings::get('industries',[])))->sortBy('name')->values();
        $judge_countries = $countries->merge($industries);
        $categories = $this->category->makeModel()
            ->select('id','name')
            ->orderBy('name', 'asc')
            ->get();
        $num_judge = $judge_countries->count();
        $is_realtime=true;// @todo: check condition on config
        return view('result.index',compact("categories","countries",'num_judge','is_realtime', 'judge_countries'));
    }

    public function getSemiList(Request $request){
//        if(!is_deadline('semi_final_result_date') ){
        if(!is_start_date('semi_final_result_date') && \Auth::user()->is_super_admin!=1 ){
            return Datatables::of([])->make(true);
        }
        $type = $request->get('type','semi');
        $semiResults=$this->result->makeModel()->where('type',$type)->where('status','active');

        $semiResults=$semiResults->whereHas("user",function ($u)use ($request){
            $u->whereHas('categoryUsers',function ($us) use ($request){
                if ($request->has('coun') && $request->get('coun')!="") {
                    $us->where('country_id', $request->get('coun'));
                }
                if ($request->has('cat') && $request->get('cat')!="") {
                    $us->where('category_id', $request->get('cat'));
                }
            });
        });
        $semiResults=$semiResults ->get();
        return Datatables::of($semiResults)
//            ->filter(function ($query) use ($request) {
//                    $query->whereHas("user",function ($u)use ($request){
//                        $u->whereHas('categoryUsers',function ($us) use ($request){
//                            if ($request->has('coun') && $request->get('coun')!="") {
//                                $us->where('country_id', $request->get('coun'));
//                            }
//                            if ($request->has('cat') && $request->get('cat')!="") {
//                                $us->where('category_id', $request->get('cat'));
//                            }
//                        });
//                    });
//            })
            ->addColumn('id', function ($win) {
                return $this->idTable++;
            })
            ->addColumn('country', function ($result) {
                if($result->user==null  || null == $result->user->country){
                    return "";
                }
                return $result->user->country->name;
            })
            ->addColumn('category', function ($application) {
                return ucwords($application->user->candidateCategory()->name);
            })
            ->addColumn('Form', function ($result) {
                if($result==null){
                    return "";
                }
                return ucwords($result->user->application->product_name);
            })
            ->make(true);

    }

    public function getFinalList(Request $request){
        $finalResults = collect();
        return Datatables::of($finalResults)
            ->filter(function ($instance) use ($request) {
                $instance->collection = $instance->collection->filter(function ($row) use ($request) {
//                        return $row->user ;
                    return isset($row['user']) ;
                });

                if ($request->has('coun')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return $request->get('coun')==""?true :$request->get('coun')==$row['user']['country_id'] ? true :false;
                    });
                }

                if ($request->has('cat')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return $request->get('cat')==""?true :$request->get('cat')==$row['user']['category_id'] ? true :false;
//                            return Str::contains($row['category'], $request->get('category')) ? true : false;
                    });
                }
            })
            ->addColumn('id', function ($win) {
                return $this->idTable++;
            })
            ->addColumn('country', function ($application) {
                if($application==null || null ==$application->user || null == $application->user->country){
                    return "";
                }
                return $application->user->country->name;
            })
            ->addColumn('category', function ($application) {
                return ucwords($application->user->category->name);
            })
            ->addColumn('Form', function ($application) {
                if($application==null){
                    return "";
                }
                return ucwords($application->product_name);
            })
            ->make(true);
    }

    public function generateSemiResult(Request $request){
//        is_deadline();
        /*
         * @todo : check deadline
         * doing
         */
        $auth = \Auth::user();
        $wins = collect();
        $categories = $this->category->makeModel()->get();
        $i=0;

        foreach ($categories as $cat){
            if($request->has('cat') && $request->get('cat')!=$cat->id ) {
                continue ;
            }
            $judges = $this->judge->findSemiWinerAppInCat($cat);
            foreach ($judges as $t) {
                $tmp = $this->application->find($t['app_id']);
                if($cat->id == 2 && (!$tmp || !$tmp->user )){
                    echo  "There is something wrong with Generation the semi result Plsease contact Admin to check!!!";
                    exit;
                    //dd($judges,$cat->toArray(),$tmp,$t);
                }
                if (null != $tmp &&  $tmp->user){
                    $r = new Result();
                    $r->total= isset($t['score'])?$t['score']:$t['total'];
                    $r->user_id = $tmp->user->id;
                    $r->category_id = $cat->id;
                    $r->type = "semi";
                    $r->rank= $t['order'];
                    $r->generated_by = $auth->id;
                    $r->created_at = Carbon::now();
                    $wins->push($r);
                }
            }
        }
        Result::where('type','semi')->where('status','active')->update(['status'=>'revision']);
        Result::insert($wins->toArray());
//        return redirect()->route("result.index")->with(['success',"Semi Final Data Generate Success "]);
        return redirect(route('result.index')."#semi")->with(['success'=>"Semi Final Data Generate Success !!!"]);
    }

    public function generateFinalResult(Request $request){

        $type = $request->get('type','final');
        $auth = \Auth::user();
        $wins = collect();
        $categorys = $this->category->makeModel()->get();
        $i=0;
        foreach ($categorys as $category) {
            $results = $this->judge->findFinalWinerApp($category);
            if (!$results) {
                continue;
            }
            foreach ($results as $result) {
                $r = new Result();
                $r->total = $result->score;
                $r->category_id = $category->id;
                $r->user_id = $result->user_id;
                $r->type = "final";
                $r->total_star = $result->stars;
                $r->generated_by = $auth->id;
                $r ->rank = $result->rank;
                $r->created_at = Carbon::now();
                $wins->push($r);
            }
        }

        Result::where('type','final')->where('status','active')->update(['status'=>'revision']);
        Result::insert($wins->toArray());
        return redirect(route('result.index')."#final")->with('success',"Generate Success !!!");
    }
    // start old code

    /**
     * not use
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finalResult(){

        if(strcasecmp(\Setting::get("CAN_FINAL_JUDGE","TRUE"),"TRUE")==0  && !\Auth::user()->is_super_admin){
            $msg="The result of Final judging will be available soon !! ";
            $type="red";
            return view('layouts.message',compact('msg','type'));
        }
        $categories = Category::all();
        $judges = User::has('finalJudges','>=',18)->orderBy('id')->get();
        if(strcasecmp( \Setting::get("SHOW_NOT_COMPLETE","FALSE"),"TRUE")==0 ){
            $judges = User::has('finalJudges')->orderBy('id')->get();
        }
        $num_judge = $judges->count();
        return view('result.final',compact("judges","num_judge","categories"));
    }

    /**
     * real time result
     * @param Request $request
     * @return mixed
     * @throws \Bosnadev\Repositories\Exceptions\RepositoryException
     */
    public function finalResultList(Request $request)
    {

//        this us in fila result list
        if(( !is_start_date('final_judge_date') || \Setting::get("CAN_FINAL_JUDGE") ) && \Auth::user()->is_super_admin!=1 ){
            return Datatables::of([])->make(true);
        }
        $wins = $this->judge->getFinalResult();
        return Datatables::of($wins)

            ->filter(function ($instance) use ($request) {
                if ($request->has('cat')) {
                    $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                        return $request->get('cat')==""?true :$request->get('cat')==$row['category_id'] ? true :false;
                    });
                }
            })

            ->make(true);

    }


}
