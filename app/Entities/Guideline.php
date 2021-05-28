<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Traits\HasRoles;

class Guideline extends Model
{
    use HasRoles;
    protected $table = 'guidelines';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'role_id','title','description','status'
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }
    public function role()
    {
        return $this->belongsTo('App\Entities\Role');
//        return $this->hasOne('Spatie\Permission\Contracts\Role');
    }


}
