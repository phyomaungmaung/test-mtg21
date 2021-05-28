<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Repositories\CountryRepository;
use App\Forms\CountryForm;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\Datatables\Datatables;
class CountryController extends Controller {


    private $country;

    public function __construct(CountryRepository $country) {

        $this->country = $country;
        $this->idTable = 1;

    }
    public function create(FormBuilder $formBuilder){
        $form = $formBuilder->create(CountryForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  route('country.store'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'novalidate'=>  'novalidate'
            ]
        );
        
        $edited = false;
        return view('country.create', compact('form','edited'));
    }

    public function index()
    {
        return view('country.index');
        
    }
    
     public function getList()
    {
        $country = $this->country->makeModel()->orderBy('name', 'asc')->get();
        
        return Datatables::of($country)
            ->addColumn('id',function ($country){
                    return $this->idTable++;
                })
            ->addColumn('name', function ($country) {
                    return ucwords($country->name);
                })
            ->addColumn('code', function ($country) {
                    return ucwords($country->bref);
                })
            ->addColumn('flag', function ($country) {
                    return url($country->flag);
                })
            ->addColumn('action', function ($country) {
                    $result = '<a href="'.route('country.edit', $country->id).
                    '" class="btn btn-icon btn-primary btn-xs m-b-3" title="Edit" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>';
                    $result .= '<a onclick="javascript:clickDestroy(this); return false;" data-item="'.$country->id.'" href="'.route('country.destroy', $country->id).'" class="sw-delete btn btn-icon btn-danger btn-xs m-b-3" title="Delete" ><i class="fa fa-trash-o"></i></a>';
                    return $result;
                })
            ->make(true);
    }

    public function store(FormBuilder $formBuilder , Request $request)
    {
        $id = $request->get('id');
        $form = $formBuilder->create(CountryForm::class);
        $data = $request->all();
        if (!$form->isValid()) {

            return redirect()->back()
                            ->withErrors($form->getErrors())
                            ->withInput()
                            ->with(['edited'=>true]);
        }

        if(Input::hasFile('flag')){
            $image = $request->file('flag');
            $image_name = $request->file('flag')->getClientOriginalName();
            $request->file('flag')->move(base_path().'/public/images/flag', $image_name);
//            $data = ($request->except(['image']));
            $data['flag'] = 'images/flag/'.$image_name;
//            dd(['true',$data]);
        }else{
            $data['flag'] = 'noimage.jpg';
        }

        // $data = $request->all();

        if(!$id){
            // flash()::messag
            $this->country->create($data);
        }else{
            $countryInfor = $this->country->find($id);
            if(!Input::hasFile('flag'))
            $data['flag']=$countryInfor->flag;
            $countryInfor->update($data);
        }
        
        flash()->info('Your data was created.');
        return redirect(route('country.index'))->with(['success'=>'Your record has been successfully saved']);

        // Do saving and other things...
    }

    public function postDelete()
    {
        $id_item = Input::get('item');
        if($id_item){
            $this->country->delete($id_item);
            return "success";
        }
        return "failed";
    }

    public function edit(FormBuilder $formBuilder,$id)
    {
        $countryInfor = $this->country->find($id);
        $form = $formBuilder->create(CountryForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  route('country.store'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'novalidate'=>  'novalidate',
                'model'     =>  $countryInfor
            ]
        );

        if (empty($countryInfor)):

            // flash()->error(lang('The record not found.'));
            return redirect(route('country.index'))->with(['info'=>lang('The record not found.')]);

        endif;
        $edited = $countryInfor->flag;
        return view('country.create', compact('form','edited'));
    }

    public function getListJson(Request $request){
        $is_final=false;
        if($request->has('utype')){
            $utype=$request->input('utype');
            if($utype!='Judge'){
                $is_final=true;
            }
        }
        $country= $this->country->getListSelect($is_final);
        return json_encode(array_merge([0=>[]],$country));
    }

}



