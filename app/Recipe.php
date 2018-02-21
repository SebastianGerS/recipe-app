<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = [
      'name',
      'time',
      'img_url',
      'recipe_link'
    ];

    public function lists()
    {
      return $this->belongsToMany('App\Userlist', 'userlists_recipes');
    }

    public function ingredients()
    {
      return $this->belongsToMany('App\Ingredient', 'recipe_ingredients');
    }

    public function filters()
    {
      return $this->belongsToMany('App\Filter', 'recipes_filters');
    }
}
