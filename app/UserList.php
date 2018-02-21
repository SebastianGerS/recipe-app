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

    public function recipes() 
    {
        return $this->belongsToMany('App\Recipe', 'userlists_recipes');
    }

    public function ingredients() 
    {
        return $this->belongsToMany('App\Ingredient', 'userlists_ingredients');
    }
}
