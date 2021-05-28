<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class CountryForm extends Form
{
    public function buildForm()
    {
        $this
        	->add('id', 'hidden')
            ->add('name', 'text')
            ->add('bref', 'text')
            ->add('flag', 'file',[
                    'attr'  =>  ['class' => 'form-control field-input file-loading', 'id' => 'flag', 'data-show-upload' => 'false'],
                    'label' => lang('Flag')
                ]);
    }
}
