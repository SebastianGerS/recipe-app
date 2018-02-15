<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest 
{

  public function Authorize() 
  {
    return true;
  }

  public function rules() 
  {
    return [
      'name' => 'required|string|unique:users',
      'email' => 'required|email|unique:users',
      'password' => 'required|string|min:6'
    ];
  }

}