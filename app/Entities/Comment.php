<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $table = 'comments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'comment', 'commented_on','meta_key','commented_by','status'
    ];
    
    public $timestamps = true;

    public function users()
    {
        return $this->hasMany('App\Entities\User');
    }
    public function commenter()
    {
        return $this->belongsTo('App\Entities\User','commented_by');
//        return $this->hasMany('App\Entities\User');
    }

}
