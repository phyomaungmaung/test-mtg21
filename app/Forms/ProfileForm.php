<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Repositories\CategoryRepository;
use App\Repositories\CountryRepository;

class ProfileForm extends Form
{
	function __construct(CategoryRepository $category,CountryRepository $country){
		$this->arrc=$country->makeModel()->select('id','name')->get();
		$this->arr=$category->makeModel()->select('id','name')->get();
	}
    public function buildForm()
    {
        $arr_coun=[];
        foreach ($this->arrc as $key => $val) {
            $arr_coun[$val->id]=$val->name;
        }

    	$arr_c=[];
        foreach ($this->arr as $key => $val) {
            $arr_c[$val->id]=$val->name;
        }

        $this
            ->add('username', 'text',['rules' => 'required',])
            ->add('email', 'email',['rules' => 'required',])
            ->add('country_id', 'select', [
                'choices' => $arr_coun,
                'empty_value' => lang('Select Country'),
                'label'=>'Country'])
            ->add('category_id', 'select',[
                'choices' => $arr_c,
                'empty_value' => lang('Select Category'),
                'label'=>'Category']);
    }
}
