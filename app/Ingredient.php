<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'unit_of_measurement'
    ];
    
    public function lists()
    {
      return $this->belongsToMany('App\Userlist', 'userlists_ingredients');
    }

    public function recipes()
    {
        return $this->belongsToMany('App\Recipe', 'recipe_ingredients');
    }
}
