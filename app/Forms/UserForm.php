<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Repositories\CountryRepository;
use App\Repositories\CategoryRepository;
use Spatie\Permission\Contracts\Role;

class UserForm extends Form
{
	function __construct(CategoryRepository $category,CountryRepository $country,Role $role){
		
//		$this->arr=$country->makeModel()->select('id','name')->get();
        $this->arr=$country->getList();
        $this->arrc=$category->makeModel()->select('id','name')->get();
        // $this->role=$role::where('name','!=','Candidate')->where('name','!=','Judge')->select('id','name')->get();
        $this->role=$role::where('name','!=','Candidate')->select('id','name')->get();
	}
    public function buildForm()
    {
//    	$arr_c=[];
//        foreach ($this->arr as $key => $val) {
//            $arr_c[$val->id]=$val->name;
//        }
//
        $arr_c=$this->arr;
        $arr_cate=[];
        foreach ($this->arrc as $key => $val) {
            $arr_cate[$val->id]=$val->name;
        }

        $arr_role=[];
        foreach ($this->role as $key => $val) {
            if($val->name=="Admin"||$val->name=="Representer"){
                $arr_role[ucwords($val->name)]=ucwords($val->name);
            }

        }

        $this
        	->add('id','hidden')
            ->add('username', 'text',['rules' => 'required',])
            ->add('email', 'email',['rules' => 'required',])
            ->add('country', 'select', [
			    'choices' => $arr_c,
			    'empty_value' => lang('Select Country'),
			    'label'=>'Country',
			    'rules' => 'required'])
            ->add('country_id', 'select', [
                'choices' => $arr_c,
                'empty_value' => lang('Select Country'),
                'label'=>'Country'])
            ->add('category_id', 'select',[
                'choices' => $arr_cate,
                'empty_value' => lang('Select Category'),
                'label'=>'Category',
                'attr'=>['disabled'=>'disabled'] ])
            ->add('roles', 'select',[
                'choices' => $arr_role,
                'empty_value' => lang('Select Role'),
                'label'=>'Role',
                'rules' => 'required'
                ]);
            
    }
}
