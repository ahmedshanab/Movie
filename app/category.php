<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    // protected $fillable = ['name'];

    // is opsite of fillable ==> if guarded is empty [] that mean will allow for all fields
    protected $guarded = [];

    // edit(category $category) will search depend on username not on id
    // public function getRouteKeyName(){
    //     return 'username';
    // }


    public function movies(){

       return $this->belongsToMany('App\Movie');
    }

    public function getNameAttribute($value){

        return ucfirst($value);
    }

    public function scopeSearch($query, $search){
        
        return $query->when($search, function($q) use ($search){
            return $q->where('name', 'LIKE', "%$search%");
        });
    }
}

