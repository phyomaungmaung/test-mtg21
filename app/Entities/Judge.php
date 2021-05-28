<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
/**
     * Run the migrations.
     * in is innovation
     * ps is problem solving
     * pv is public value
     * ti transparancy and iq
     * ef efficiency
     * pm performance
     * qt quality
     * rt reliability
     * op organization presentation
     * en enquiries
     * ms marketing strategy
     * cu customer
     * fi financial
     * ca competitive advantage
     * me market entry
     * sc scalability
     * tm team organization
     * sh stackholder
     * @return void
     */
class Judge extends Model
{
    protected $table = 'judges';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'app_id','user_id','status','category_id','type','in','ps','pv','ti','ef','pm','qt','rt','op','en','ms','cu','fi','ca','me','sc','tm','sh','total','num_star'
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

    public function application()
    {
        return $this->belongsTo('App\Entities\Application','app_id');
    }

    

}
