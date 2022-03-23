<?php

namespace App;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    protected $fillable = ['name'];

    // Scope
    public function scopeSearch($query, $search){

        return $query->when($search, function($q) use ($search) {
            return $q->where('name', 'LIKE', "%$search%");
        });
    }

    public function scopeRoleNotSearch($query, $search){

            return $query->whereNotIn('name', (array) $search);
        
    }


}
