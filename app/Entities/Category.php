<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'abbreviation','created_by'
    ];
    
    public $timestamps = true;

   public function users()
   {
       return $this->belongsToMany('App\Entities\User')->withPivot(['type','country_id']);
   }

}
