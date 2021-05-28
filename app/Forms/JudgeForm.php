<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Repositories\CountryRepository;
use App\Repositories\CategoryRepository;
use Spatie\Permission\Contracts\Role;

class JudgeForm extends Form
{
    function __construct(CategoryRepository $category,CountryRepository $country,Role $role){
        
//        $this->arr=$country->makeModel()->select('id','name')->get();
        $this->arr= $country->getList();
//        dd($this->arr);
        $this->arrc=$category->makeModel()->select('id','name')->get();
        
    }
    public function buildForm()
    {
        $arr_c= $this->arr;
//        $arr_c=[];
//        $arr_industry=['Korea','Japan',"China"];
//        foreach ($this->arr as $key => $val) {
//            if(!in_array($val->name, $arr_industry))
//            $arr_c[$val->id]=$val->name;
//        }
        $arr_cate=[];
        foreach ($this->arrc as $key => $val) {
            $arr_cate[$val->id]=$val->name;
        }

        $this
            ->add('id','hidden',['attr'=> ['id'=>'id']])
            ->add('username', 'text',['rules' => 'required',])
            ->add('email', 'email',['rules' => 'required',])
//            ->add('password','password',['rules' => 'required'])
//            ->add('password_confirmation','password',['rules' => 'required'])
            ->add('type', 'select', [
                'choices' => ["Judge"=>"Online Judge","Final Judge"=> "Final Judge"],
                'empty_value' => lang('Select Type'),
                'label'=>'Type'])
            ->add('country_id', 'select', [
                'choices' => $arr_c,
                'empty_value' => lang('Select Country'),
                'label'=>'Country'])
            ->add('category_id', 'select',[
                'template'=> 'inputs.selectCustom',
                'choices' => $arr_cate,
                'label'=>'Category',
                "name"=>'category_id[]',
                'attr' => [
                    'multiple' => 'multiple',
                    "id"=>'category_id',
                ]
            ]);
            
    }
}
