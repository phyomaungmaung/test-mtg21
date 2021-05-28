<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use Spatie\Permission\Contracts\Role;

class GuidelineForm extends Form
{
	function __construct(Role $role){
		

        $this->role=$role::select('id','name')->get();
        
	}
    public function buildForm()
    {

        $arr_role=[];
        foreach ($this->role as $key => $val) {
            $arr_role[$val->id]=ucwords($val->name);
        }

        $this
        	->add('id','hidden')
            ->add('title', 'text')
            ->add('description', 'textarea')
            ->add('role_id', 'select',[
                'choices' => $arr_role,
                'empty_value' => lang('Select Role'),
                'label'=>'Role',
                'rules' => 'required'
                ]);
            
    }
}
