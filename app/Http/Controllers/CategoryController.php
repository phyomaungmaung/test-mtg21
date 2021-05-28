<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
// use Validator;
use Yajra\Datatables\Datatables;
use App\Repositories\CategoryRepository;
use App\Forms\CategoryForm;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Support\ImageUploader;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller {
    
    private $category;
    public function __construct(CategoryRepository $category) {

        $this->category = $category;
        $this->idTable = 1;

    }
    public function create(FormBuilder $formBuilder){
        $form = $formBuilder->create(CategoryForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  route('category.store'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                // 'novalidate'=>  'novalidate'
            ]
        );
        
        $edited = false;
        return view('category.create', compact('form','edited'));
    }

    public function index()
    {
        return view('category.index');
    }

    public function cates(){
        $cart = $this->category->makeModel()
            ->select('id','name')
            ->orderBy('name', 'asc')
            ->get();

        return json_encode($cart);
//        return true;
    }


    public function getList()
    {
        $category = $this->category->makeModel()->orderBy('name', 'asc')->get();
        return Datatables::of($category)
            ->addColumn('id',function ($category){
                    return $this->idTable++;
                })
            ->addColumn('name', function ($category) {
                    return ucwords($category->name);
                })
            ->addColumn('abbreviation', function ($category) {
                    return ucwords($category->abbreviation);
                })
            ->addColumn('action', function ($category) {
                    $result = '<a href="'.route('category.edit', $category->id).
                    '" class="btn btn-icon btn-primary btn-xs m-b-3" title="Edit" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>';
                    $result .= '<a onclick="javascript:clickDestroy(this); return false;" data-item="'.$category->id.'" href="'.route('category.destroy', $category->id).'" class="sw-delete btn btn-icon btn-danger btn-xs m-b-3" title="Delete" ><i class="fa fa-trash-o"></i></a>';
                    return $result;
                })
            ->make(true);
    }

    public function store(FormBuilder $formBuilder , Request $request)
    {
        $id = $request->get('id');
        $form = $formBuilder->create(CategoryForm::class);
        $data = $request->all();

        if (!$form->isValid()||strlen($data['abbreviation'])>5) {
            return redirect()->back()
                            ->withErrors($form->getErrors())
                            ->withInput()
                            ->with(['error'=>"Abbreviation must be less than 5"]);
        }
 

        // $data = $request->all();
        $data['created_by']=\Auth::id();
        if(!$id){
            $this->category->create($data);
            flash()->info('Your data was created.');
        }else{
            $categoryInfor = $this->category->find($id);
            $categoryInfor->update($data);
            flash()->info('Your data was saved.');
        }
        
        
        return redirect(route('category.index'))->with(['success'=>'Your record has been successfully saved']);

        // Do saving and other things...
    }

    public function postDelete()
    {
        $id_item = Input::get('item');
        if($id_item){
            $this->category->delete($id_item);
            return "success";
        }
        return "failed";
    }

    public function edit(FormBuilder $formBuilder,$id)
    {
        $categoryInfor = $this->category->find($id);
        $form = $formBuilder->create(CategoryForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  route('category.store'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                //'novalidate'=>  'novalidate',
                'model'     =>  $categoryInfor
            ]
        );

        if (empty($categoryInfor)):

            flash()->error(lang('The record not found.'));
            return redirect(route('category.index'));
        endif;
        $edited = true;
        return view('category.create', compact('form','edited'));

    }

}



