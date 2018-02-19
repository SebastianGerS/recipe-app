<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ingredient;
use App\Userlist;
use App\Recipe;
use App\Filter;

class RecipeController extends Controller
{
    public function show(Request $request, Userlist $list, Recipe $recipe) 
    {
        if($list) {
            if ($recipe) {
                if($list->recipes->where('name', '=', $recipe->name)) {

                    $recipe->load('filters', 'ingredients');

                    $cuisines = [];
                    $holidays = [];
                    $courses = [];
                    $ingredients = [];

                    foreach($recipe->filters as $filter) {
                        array_push(${$filter->type . 's'}, $filter->name);
                    }
                    foreach($recipe->ingredients as $ingredient) {
                        $ingredient = $ingredient->amount . ' '. $ingredient->unit_of_measurement . ' ' . $ingredient->name; 
                        array_push($ingredients, $ingredient);
                    }

                    return response()->json( [
                        'status' => 'success',
                        'recipe' => [
                            'id' => $recipe->id,
                            'name' => $recipe->name,
                            'cuisines' => $cuisines,
                            'courses' => $courses,
                            'holidays' => $holidays,
                            'time' => $recipe->time,
                            'ingredients' => $ingredients,
                            'imgUrl' => $recipe->img_url,
                            'recipeLink' => $recipe->recipe_link
                        ]
                    ], 200);
                }
            }
        }
       

        return response()->json( [
            'status' => 'not found',
            'request' => $request
        ], 404);
        
    }

    public function store(Request $request, Userlist $list)
    {
        
        $recipe = $request->recipe;
        
     
        if($list) {

            $list['recipes'] = Recipe::whereHas('lists', function($query) use ($list, $recipe) {
                $query->where('id', 'like', $list->id);
            })->where('name', 'like', $recipe['name'])->get();
         
            if (count($list['recipes']) === 0) {

                $newRecipe = Recipe::where('name', 'like', $recipe['name'])->get();

                if(count($newRecipe) === 0) {

                   
                   
                    $newRecipe = Recipe::create(['name' => $recipe['name'], 'time' => $recipe['time'], 'img_url' => $recipe['imgUrl'], 'recipe_link' => $recipe['recipeLink']]);
                    
                    foreach($recipe['ingredients'] as $ingredient) {
                        if(is_numeric(substr($ingredient,0,1))) {
                            $parts = explode(' ',$ingredient);
                            $amount = $parts[0];
                            $unit = $parts[1];
                            unset($parts[0]);
                            unset($parts[1]);
                            $name = implode(' ', $parts);
                            
                            $ingredient = Ingredient::where('name','like', $name)->where('amount','like' ,$amount)->where('unit_of_measurement', 'like' ,$unit)->get();
                            if (count($ingredient) === 0) {
                                $ingredient = Ingredient::create(['name' => $name, 'amount' => $amount, 'unit_of_measurement' => $unit]);
                                $newRecipe->ingredients()->attach($ingredient->id);
                            } else {
                                $newRecipe->ingredients()->attach($ingredient[0]->id);
                                
                            }
                            
                        } else {
    
                            $ingredient = Ingredient::firstOrCreate(['name' => $ingredient]);
                            $newRecipe->ingredients()->attach($ingredient->id);
                            
                        }                        
                     
                    }
                 
              
    
                    foreach($recipe['cuisines'] as $cuisine) {
                     
                        $filter = Filter::firstOrCreate(['name' => $cuisine], ['type' => 'cuisine']);
                       
                        $newRecipe->filters()->attach($filter->id);
                        
                    }
               
                    foreach($recipe['holidays'] as $holiday) {
    
                    
                        $filter = Filter::firstOrCreate(['name' => $holiday], ['type' => 'holiday']);
                       
                       
                        $newRecipe->filters()->attach($filter->id);
    
                    }
              
                    foreach($recipe['courses'] as $course) {
    
                    
                        $filter = Filter::firstOrCreate(['name' => $course], ['type' => 'course']);
                    
                       
                        $newRecipe->filters()->attach($filter->id);
                        
                    }

                    $newRecipe->lists()->attach($list->id);

                }else {
                    

                    $newRecipe[0]->lists()->attach($list->id);

                }
               
               
                
                return response()->json( [
                    'status' => 'success',
                    'recipe' => $newRecipe,
                    'message' => "The recipe was added to your list!"
                ], 200);
                
            }

            return response()->json( [
                'status' => 'error',
                'recipe' => $recipe,
                'message' => "The recipe is alredy in your list!"
            ]);
        

        }

        


    }
}
