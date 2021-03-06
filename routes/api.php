<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('register', 'AuthController@register');
    
    Route::post('lists', 'ListController@store');
    Route::get('lists', 'ListController@index');
    Route::delete('lists/{list}', 'ListController@destroy');

    Route::post('lists/{list}/ingredients', 'IngredientController@store');
    Route::delete('lists/{list}/ingredients/{ingredient}', 'IngredientController@destroy');

    Route::get('lists/{list}/recipes/{recipe}', 'RecipeController@show');
    Route::post('lists/{list}/recipes', 'RecipeController@store');
    Route::delete('lists/{list}/recipes/{recipe}', 'RecipeController@destroy');
});
