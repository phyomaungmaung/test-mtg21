<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryUser extends Model
{

    protected $table = 'category_user';

    protected $primaryKey = ['category_id','user_id','type','country_id'];

    protected $fillable = [
        'user_id', 'category_id','country_id','type','num_form'
    ];
    
    public $timestamps = true;
    public $incrementing = false;

//    public function country()
//    {
//        return $this->hasMany("App\Entities\Country");
////            ->orderBy('id','DESC')->first();
//    }
    public function users()
    {
        return $this->hasMany('App\Entities\User');
    }
    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }

    public function judge(){
        return $this->hasOne('App\Entities\User','id','user_id');
    }
    public function country(){
        return $this->hasOne('App\Entities\Country','id','country_id');
    }
    public function category(){
        return $this->hasOne('App\Entities\Category','id','category_id');
    }



/*
**
* Set the keys for a save update query.
*
* @param  \Illuminate\Database\Eloquent\Builder  $query
* @return \Illuminate\Database\Eloquent\Builder
*/
    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }

}
