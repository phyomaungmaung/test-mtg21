<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Repositories\CategoryRepository;
use App\Repositories\CountryRepository;

class CandidateForm extends Form
{
	function __construct(CategoryRepository $category,CountryRepository $country){
		$this->arr=$category->makeModel()->select('id','name')->get();
//        $this->arrcon=$country->makeModel()->select('id','name')->get();
        $this->arrcon= $country->getList();
        $this->country=\Auth::user()->country_id;
        
	}
    public function buildForm()
    {
    	$arr_c=[];
        foreach ($this->arr as $key => $val) {
            $arr_c[$val->id]=$val->name;
        }
        $arr_con = $this->arrcon;

        $this
        	->add('id','hidden')
            ->add('username', 'text',['rules' => 'required','label'=>'Company'])
            ->add('email', 'email',['rules' => 'required',])
            ->add('country_id', 'select',[
            'choices' => $arr_con,
            'empty_value' => lang('Select Country'),
            'label'=>'Country',
            // 'selected'=>$this->country,
        ]);


        if( \Setting::get("LIMIT_CAT_PER_CANDIDATE",1)<=1 ){
            $this->add('category_id', 'select', [
            'choices' => $arr_c,
            'empty_value' => lang('Select Categories'),
            'label'=>'Category',
            'rules' => 'required']);
        }else{
            $this ->add('categories', 'form', [
                'class' => $this->settingsForm($arr_c),
                'name' => false,
                'formOptions' => [],
                'label' => false,
                'wrapper' => false,
            ]);
        }


//
    }

    public function settingsForm($choices)
    {
        $form = $this->formBuilder->plain();

        $form->add('ids', 'choice', [
            'label' => 'Category',
            'choices' => $choices,
            'expanded' => false,
            'multiple' => true,
            'attr' => [
                'class' => 'select2_multiple form-control cat_multi',
                'multiple'=>"multiple"
            ],
        ]);

        return $form;
    }
}
