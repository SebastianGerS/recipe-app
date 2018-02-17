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
      return $this->morphMany('App\Userlist', 'listable', 'userlist_recipe_ingredients');
    }
}
