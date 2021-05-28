<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class User extends Authenticatable
{
    use HasRoles,Notifiable;

    protected $guard_name = 'web';

    // use HasRoles;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    protected $primaryKey = 'id';
    protected $fillable = [
        'username', 'email', 'password','active','is_super_admin','country_id','parent_id'
    ];
    
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
    public function children(){
        return $this->hasMany('App\Entities\user','parent_id','id');
    }
    public function country(){
        return $this->belongsTo('App\Entities\Country');
    }

    public function categories(){
        return $this->belongsToMany('App\Entities\Category','category_user')->withPivot(['type','country_id','num_form'])->withTimestamps();
    }
    /*
     * not relactionship
     */
    public function candidateCategory(){
        return $this->belongsToMany('App\Entities\Category')
            ->withPivot(['num_form','country_id','type'])
            ->where('type','candidate')->first();
//            ->withTimestamps();
    }

    public function candidateCategories(){
        return $this->belongsToMany('App\Entities\Category')
            ->withPivot(['num_form','country_id','type'])
            ->where('type','candidate');
//            ->withTimestamps();
    }

    public function finalCategories(){
        return $this->belongsToMany('App\Entities\Category')
            ->withPivot(['num_form','country_id','type'])
            ->where('type','final')
            ->withTimestamps();
    }

    public function onlineCategories(){
        return $this->belongsToMany('App\Entities\Category')
            ->withPivot(['num_form','country_id','type'])
            ->where('type','semi')
            ->withTimestamps();
    }

    public function countries(){
        return $this->belongsToMany('App\Entities\Country','category_user')->withPivot(['type','category_id']);
    }

    public function categoryUsers(){
        return $this->hasMany('App\Entities\CategoryUser');
    }

    public function application(){
        return $this->hasOne('App\Entities\Application');
    }

    public function scopeActive($query){
        return $query->where('active', true);
    }

    public function finalJudges(){
        return $this->hasMany('App\Entities\Judge')->where('type','final');
    }


    public static function boot()
    {
        parent::boot();

    }



}
