<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class CategoryForm extends Form
{
    public function buildForm()
    {
        $this
        	->add('id', 'hidden')
            ->add('name', 'text')
            ->add('abbreviation', 'text',['attr'=>['max'=>'4']]);
    }
}
