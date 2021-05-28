<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Repositories\CategoryRepository;

class CommentForm extends Form
{

    public function buildForm()
    {

        $this
        	->add('id','hidden')
            ->add('comment', 'text',['rules' => 'required',])
            ->add('commented_on', 'hidden')

             ;
    }
}
