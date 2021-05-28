<?php 
namespace App\Http\Controllers;
use Auth;
use Illuminate\Support\Facades\Input;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Repositories\UserRepository;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\Datatables\Datatables;

class RoleController extends Controller {

	public function __construct(UserRepository $user)
	{
		$this->user = $user;
        $this->idTable = 1;
	}
	public function index(){

		return view('role.index');
	}
    
	public function roleList()
	{
    
		$role = Role::orderBy('created_at', 'desc')->get();
        return Datatables::of($role)
        	->addColumn('id',function ($role){
        		return $this->idTable++;
        	})
            ->addColumn('action', function ($role) {
                    $result = '<a href="'.route('role.edit', $role->id).'" class="btn btn-icon btn-primary btn-xs m-b-3" title="Edit" style="margin-right: 5px;"><i class="fa fa-edit"></i></a>';
                    
                    $result .= '<a onclick="javascript:clickDestroy(this); return false;" data-item="'.$role->id.'" href="'.route('role.destroy', $role->id).'" class="sw-delete btn btn-icon btn-danger btn-xs m-b-3" title="Delete" ><i class="fa fa-trash-o"></i></a>';
                    return $result;
                })
            ->make(true);
	}
	public function create(FormBuilder $formBuilder){
		$form = $formBuilder->create(\App\Forms\RoleForm::class,
            [
                'method'    =>  'POST',
                'url'       =>  route('role.store'),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'novalidate'=>  'novalidate',
                'model'     =>  null,
            ]
        );
        $jsonRole = $this->listPermission();
        $pselected = null;
        $porigin = null;
        return view('role.create', compact('form','jsonRole','pselected','porigin'));
	}
    public function store(FormBuilder $formBuilder){
        return $this->save($formBuilder);
    }  

    public function update($id,FormBuilder $formBuilder){
        return $this->save($formBuilder);
    }

    public function edit(FormBuilder $formBuilder,$id){
        $role = Role::find($id);
        $form = $formBuilder->create(\App\Forms\RoleForm::class,
            [
                'method'    =>  'PUT',
                'url'       =>  route('role.update',$id),
                'role'      =>  'form',
                'class'     =>  'form-horizontal',
                'enctype'   =>  'multipart/form-data',
                'novalidate'=>  'novalidate',
                'model'     =>  $role
            ]
        );
        $pselected = [];
        $porigin = null;
        $jsonRole = $this->listPermission();
        $role_p = $role->permissions;
        if($role_p){
            foreach ($role_p as $pkey => $pvalue) {
                $pselected[] = $pvalue->name;
            }
        }
        return view('role.create', compact('form','jsonRole','pselected','porigin'));
    }

    function listPermission(){

        $permission=config('roles');
        $getAllRole=[];
        foreach($permission as $key=>$value){
            $arrRole=null;
            foreach ($value as $ind => $val) {
                $arrStr=$val.'-'.$key;
                $arrRole[]=$arrStr;
            }
            $getAllRole[ucwords($key)]=$arrRole;
        }
        $jsonRole=json_encode($getAllRole);
        return $jsonRole;
    }
    function save($formBuilder){
        try {
            $form = $formBuilder->create(\App\Forms\RoleForm::class);
            $getRole = Input::get('role');
            $getPermission = Input::get('permission');
            $getId = Input::get('id');
            $p_selected = ($getRole?explode(",", $getRole):null);
            $p_origin = ($getPermission?explode(",", $getPermission):null);
            if(Input::get('role')){
                if($getId){
                    $rules = ['name' => 'required|unique:roles,name,'.$getId ];
                    $form->validate($rules);
                }
                
                if(!$form->isValid()){
                    flash()->error("Please verify all data is corrected!");
                    return redirect()->back()->withErrors($form->getErrors())->withInput()->with(["pselected"=>$p_selected,"porigin"=>$p_origin]);
                }else{
                    $role = trim(Input::get('name'));                    
                    $result = $this->user->createRole($role,$p_selected,$getId);
                    if($result){
                        flash()->success(lang('The record was successfully saved.'));
                        return redirect(route('role.index'));
                    }
                }
            }else{
                flash()->error("Please select at lease one permission!");
                return redirect()->back()->withInput()->with(["pselected"=>$p_selected,"porigin"=>$p_origin]);
            }

        } catch (Exception $e) {
            
        }
    }
    public function postDelete(){
        $id_role = Input::get('item');
        $role = Role::find($id_role);
        if(count($role->users)){
           return "failed";
        }else{
            $role->delete();
            return "success";
        }
    }
}