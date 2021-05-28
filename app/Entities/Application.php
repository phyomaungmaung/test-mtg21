<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'user_id','address','phone','fax','website','email','company_name','company_profile','ceo_name',
        'ceo_email','contact_name','contact_position','contact_email','contact_phone','product_name',
        'product_description','product_uniqueness','product_quality','product_market','business_model',
        'status','approved_by','video_demo'
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }

    public function video()
    {
        return $this->hasOne('App\Entities\Video')->orderBy('id','DESC')->first();
    }

    public function videos()
    {
        return $this->hasMany('App\Entities\Video')->orderBy('id','DESC');
    }

    public function comments()
    {
//        return $this->hasMany('App\Entities\Comment','meta_key')->where('commented_on','register_form')->whereNotIn('status',['reviewed','achieved']);
        return $this->hasMany('App\Entities\Comment','meta_key')->where('commented_on','register_form')->orderBy('id','DESC');
    }

}
