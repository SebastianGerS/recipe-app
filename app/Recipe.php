<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
      'id',
      'name',
      'time',
      'img_url',
      'recipe_link'
    ];

    public function lists()
    {
      return $this->morphMany('App\Userlist', 'listable', 'userlist_recipe_ingredients');
    }

    public function ingredients()
    {
      return $this->hasMany('App\Ingredient', 'recipe_ingredients');
    }

    public function filters()
    {
      return $this->hasMany('App\Filter', 'recipes_filters');
    }
}
