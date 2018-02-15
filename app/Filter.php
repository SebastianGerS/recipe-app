<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    protected $fillable = [
        'name',
        'type'
    ];
    
    public $timestamps = false;

    public function recipes()
    {
      return $this->belongsToMany('App\Recipe', 'recipes_filters');
    }
}
