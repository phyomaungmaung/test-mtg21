<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'application_id','youtube_id','path','mine_type',
        'status'
    ];

    public $timestamps = true;

    public function application()
    {
        return $this->belongsTo('App\Entities\Application');
    }



//
//    public function video()
//    {
//        return $this->has('App\Entities\User');
//    }



}
