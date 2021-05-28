<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ApplicationForm extends Form
{
    public function buildForm()
    {


        $this
        	->add('id', 'hidden',[ 'attr'=>[ 'id'=>'app_id']])
            ->add('user_id','hidden')
            ->add('address', 'text',['rules'=>'required'])
            ->add('phone', 'text',['rules'=>'required'])
            ->add('fax', 'text')
            ->add('website', 'text',['rules'=>'required'])
            ->add('email', 'text',['rules'=>'required'])
            ->add('company_name', 'text',['rules'=>'required'])
            ->add('company_profile', 'textarea',['rules'=>'required'])
            ->add('ceo_name', 'text',['rules'=>'required'])
            ->add('ceo_email', 'text',['rules'=>'required'])
            ->add('contact_name', 'text',['rules'=>'required'])
            ->add('contact_position', 'text',['rules'=>'required'])
            ->add('contact_email','text',['rules'=>'required'])
            ->add('contact_phone', 'text',['rules'=>'required'])
            ->add('product_name', 'text',['rules'=>'required'])
            ->add('product_description','textarea',['rules'=>'required'])
            ->add('product_uniqueness','textarea',['rules'=>'required'])
            ->add('product_quality','text',['rules'=>'required',
//                'error_messages'=>['product_quality.required'=>'Product Quality is mandatory']
            ])
            ->add('product_market','textarea',['rules'=>'required'])
            ->add('business_model','textarea',['rules'=>'required'])
            ->add('status','hidden')
//            ->add('video_demo','file')
            ->add('video_demo','file',[
            'attr'  =>  ['class' => 'form-control field-input file-loading', 'id' => 'video_demo', 'data-show-upload' => 'false'],
                    'label' => lang('video')
                ])
 
            ;
    }
}
