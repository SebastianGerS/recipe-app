<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserList extends Model
{
    protected $fillable = [
        'name',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function listable() 
    {
        return $this->morphTo('userlist_recipes_ingredients');
    }
}
