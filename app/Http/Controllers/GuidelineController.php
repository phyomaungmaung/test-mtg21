<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
// use Validator;
use Yajra\DataTables\DataTables;
use App\Repositories\GuidelineRepository;
use App\Repositories\RoleRepository;
use App\Forms\GuidelineForm;
use Kris\LaravelFormBuilder\FormBuilder;
//use App\Support\ImageUploader;
use PDF;
use Spatie\Permission\Contracts\Role;


class GuidelineController extends Controller {
    
    private $guideline;
    public function __construct(Role $role,GuidelineRepository $guideline) {
        $this->role=$role;
        $this->guideline = $guideline;
        $this->idTable = (intval(Input::get('start')))+1;
    }
    public function create(FormBuilder $formBuilder){
        $form = $formBuilder->create(GuidelineForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  route('guideline.store'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'id'=>'guideline',
                'novalidate'=>  'novalidate',
            ]
        );
        $can_edite=true;
        $edited = false;

        return view('guideline.create', compact('form','edited','can_edite'));
    }
    
    public function index()
    { 
        return view('guideline.index');
    }
    
    public function getList()
    {

        $guideline = $this->guideline->makeModel()->orderBy('id', 'asc')->get();


            return Datatables::of($guideline)
                ->addColumn('id',function ($guideline){
                        return $this->idTable++;
                    })
                ->addColumn('title', function ($guideline) {
                        return ucwords($guideline->title);
                    })
                ->addColumn('role', function ($guideline) {
                    return $guideline->role->name;
                    })
                
                ->addColumn('status',function($guideline){
                        return ucwords($guideline->status);
                    })
                ->addColumn('action', function ($guideline) {
                        $result='';
//                        $result .= '<a href="'.route('guideline.view', $guideline->id).
//                        '" class="btn btn-icon btn-primary btn-xs m-b-3" title="Review" style="margin-right: 5px;"><i class="fa fa-list"></i></a>';

                    $result = '<a href="'.route('guideline.edit', $guideline->id).
                        '" class="btn btn-icon btn-primary btn-xs m-b-3" title="Edit" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>';


                    $result .= '<a onclick="javascript:clickDestroy(this); return false;" data-item="'.$guideline->id.'" href="'.route('guideline.destroy', $guideline->id).'" class="sw-delete btn btn-icon btn-danger btn-xs m-b-3" title="Delete" style="margin-right: 5px;"><i class="fa fa-trash-o"></i></a>';
                    $result .= '<a    href="'.route('guideline.view', $guideline->id).'" class="btn btn-icon btn-info btn-xs m-b-3" title="Delete" ><i class="fa fa-eye"></i></a>';
                    return $result;
                    })
                ->make(true);
    }

    public function getAseanList()
    {
        $guideline = $this->guideline->makeModel()->where('status','=','accepted')->orderBy('id', 'asc')->get();
        //dd($guideline[0]->user->username);
            return Datatables::of($guideline)
                ->addColumn('id',function ($guideline){
                        return $this->idTable++;
                    })
                ->addColumn('title', function ($guideline) {
                        return ucwords($guideline->title);
                    })

                ->addColumn('role', function ($guideline) {
                        return ucwords($guideline->role->name?$guideline->role->name:"");
                    })
                ->addColumn('status',function($guideline){
                        return ucwords($guideline->status);
                    })
                ->addColumn('action', function ($guideline) {
                        $result='';
                        $result .= '<a href="'.route('guideline.view', $guideline->id).
                        '" class="btn btn-icon btn-primary btn-xs m-b-3" title="Review" style="margin-right: 5px;"><i class="fa fa-list"></i></a>';
                        $result .= '<a href="'.route('guideline.player', $guideline->id).
                        '" class="btn btn-icon btn-danger btn-xs m-b-3" title="Video" style="margin-right: 5px;"><i class="fa fa-youtube-play"></i></a>';
                        
                        
                        return $result;
                    })
                ->make(true);

    }
    public function aseanGuideline()
    { 
        return view('guideline.aseanlist');
    }

    public function store(FormBuilder $formBuilder , Request $request)
    {
        $id = $request->get('id');
        $form = $formBuilder->create(GuidelineForm::class);
        $data = $request->all();
        if(!$form->isValid()){
            return redirect()->back()->withErrors($form->getErrors())->withInput()->with(['warning'=>'The Guide Line not saved  !!!']);
        }
        $data['description']=$request->has('description')?str_replace(url('/'),'',$data['description']):"";
        if(!$id){
            $guidelineInfor=$this->guideline->create($data);
        }else{
            $guidelineInfor = $this->guideline->find($id);
            $guidelineInfor->update($data);
        } ;
        return redirect(route('guideline.index'))->with(['info'=>'Your data was saved.']);
    }

    public function postDelete()
    {
        $id_item = Input::get('item');
        if($id_item){
            $this->guideline->delete($id_item);
            return "success";
        }
        return "failed";
    }

    public function edit(FormBuilder $formBuilder,$id)
    {
        $guidelineInfor = $this->guideline->find($id);
        $form = $formBuilder->create(GuidelineForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  route('guideline.store'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'novalidate'=>  'novalidate',
                'model'     =>  $guidelineInfor
            ]
        );
        $can_edite=true;
        if (empty($guidelineInfor)):
            flash()->error(lang('The record not found.'));
            return redirect(route('guideline.index'));
        endif;
        $edited = $guidelineInfor->video_demo;

        return view('guideline.create', compact('form','edited','can_edite' ));
    }

    public function review(FormBuilder $formBuilder,$id)
    {
        $guidelineInfor = $this->guideline->find($id);
        $form = $formBuilder->create(GuidelineForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  '#',
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'novalidate'=>  'novalidate',
                'model'     =>  $guidelineInfor
            ]
        );
        $form->disableFields();
        $can_edite=true;
        if (empty($guidelineInfor)):
            flash()->error(lang('The record not found.'));
            return redirect(route('guideline.index'));
        endif;
        $edited = $guidelineInfor->video_demo;
        return view('guideline.create', compact('form','edited','can_edite'));
    }

    public function view(FormBuilder $formBuilder,$id)
    {
        $guidelineInfor = $this->guideline->find($id);

        if (empty($guidelineInfor)):
            flash()->error(lang('The record not found.'));
            return redirect(route('guideline.index'));
        endif;

        return view('guideline.view', compact(  'guidelineInfor' ));
    }
    public function help()
    {
        $roles = \Auth::user()->roles;
        if(count($roles)<1){
            return redirect()->back()->with(['info'=>'Supper admin have no Guideline ']);
        }
        $role_id= $roles[0]->id;
        $guidelineInfor = $this->guideline->findWhere(['role_id'=>$role_id])->first();
        if (empty($guidelineInfor)):
            if(\Auth::user()->hasPermissionTo('list-guideline')){
                return redirect(route('guideline.index'))->with(['info'=>'The record not found !!!']);
            }
            return redirect()->back()->with(['info'=>'no Guideline record found']);
        endif;

        return view('guideline.help', compact(  'guidelineInfor' ));
    }

}



