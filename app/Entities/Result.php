<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'user_id','category_id','status','generated_by','type','total','total_star'
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Entities\Category');
    }


}
