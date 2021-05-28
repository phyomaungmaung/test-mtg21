<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $table = 'countries';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'bref', 'flag'
    ];
    
    public $timestamps = true;

    public function users()
    {
        return $this->hasMany('App\Entities\User');
    }

}
