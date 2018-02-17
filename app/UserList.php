<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userlist extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'type',
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
