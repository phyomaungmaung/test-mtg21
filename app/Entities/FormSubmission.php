<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{

    protected $table = 'form_submissions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'form_path','user_id'
    ];
    
    public $timestamps = true;

    public function users()
    {
        return $this->hasMany('App\Entities\User');
    }

}
