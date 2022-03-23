<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laratrust\Traits\LaratrustUserTrait;
use App\Role;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'bio'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['avatar_path'];

    protected $withCount = ['movies']; // name of relation in model ==> movies

    public function getAvatarPathAttribute($value){
        return Storage::url($this->avatar);
    }

    public function ScopeWhenSearch($query, $name){

        return $query->when($query, function($q) use ($name) {
            return $q->where('name', 'like', "%$name%");
        });
    }

    public function scopeWhenRole($query, $role_id){
        return $query->when($role_id, function($q) use ($role_id) {
            return $this->scopeWhereRole($q, $role_id);
        });
    }

    public function scopeWhereRole($query, $role_name){
        return $query->whereHas('roles', function ($q) use ($role_name) {
            return $q->whereIn('name', (array)$role_name)
                    ->orWhereIn('id', (array)$role_name);
        });

    }

    public function scopeWhereRoleNot($query, $role_name){
        return $query->whereHas('roles', function ($q) use ($role_name) {
            return $q->whereNotIn('name', (array)$role_name)
                    ->whereNotIn('id', (array)$role_name);
        });

    }// end of scopeWhereRoleNot

    public function movies(){
        return $this->belongsToMany('App\Movie', 'user_movie');
    }

//    public function testCount(){
//        return User::withCount(['movies'])->get();
//    }
}
