<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class AlertMailForm extends Form
{
    public function buildForm()
    {
    	
        $this->add('content', 'textarea',[
        			'rules' => 'required',
            		'label' => lang('Content'),
            		'attr' => ['id'=>'content']
            	]);
    }
}
