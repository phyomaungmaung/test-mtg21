<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class PasswordForm extends Form
{
    public function buildForm()
    {
        $limit = \Settings::get("MIN_PWD",6);
        $this
        	->add('old_password', 'password')
            ->add('new_password', 'password',['attr'=>['max'=>$limit],'required'=>'required'])
            ->add('password_confirmation', 'password',['attr'=>['max'=>$limit],'required'=>'required']);
    }
}
