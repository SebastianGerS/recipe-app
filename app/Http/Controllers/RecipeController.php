<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ingredient;
use App\Userlist;
use App\Recipe;
use App\Filter;
use App\User;

class RecipeController extends Controller
{
    public function show(Request $request, Userlist $list, Recipe $recipe) 
    {
        if ($list) {

            if ($this->checkIfOwnsList(auth()->user(), $list->id)) {

                if ($recipe) {

                    if ($list->recipes->where('name', '=', $recipe->name)) {

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

                    return response()->json( [
                        'status' => 'not found',
                        'message' => 'The selected recipe does not exist in this list'
                    ], 404);
                }

                return response()->json( [
                    'status' => 'not found',
                    'message' => 'The selected recipe does not exist'
                ], 404);
             
            }

            return response()->json( [
                'status' => 'unauthorized',
                'message' => 'You are not unauthorized to make changes to this list'
            ], 401);
        }
       
        return response()->json( [
            'status' => 'not found',
            'request' => 'the selected list does not exist'
        ], 404);
        
    }

    public function store(Request $request, Userlist $list)
    {
        
        $recipe = $request->recipe;
     
        if($list) {

            if($this->checkIfOwnsList(auth()->user(), $list->id)) {

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

            return response()->json( [
                'status' => 'unauthorized',
                'message' => 'You are not unauthorized to make changes to this list'
            ], 401);
          
        }

        return response()->json( [
            'status' => 'not found',
            'message' => 'The selected list does not exist'
        ], 404);
    }

    public function destroy(Request $request, Userlist $list, Recipe $recipe)
    {
        
        if($list && $recipe) {
            
            if($this->checkIfOwnsList(auth()->user(), $list->id)) {

                $toBeRemoved = $list->recipes->where('id', $recipe->id)->first();
            
                if ($toBeRemoved) {

                    $recipe->lists()->detach($list->id);

                    if(count($recipe->lists) === 0){

                        $recipe->filters()->detach();
                    
                        foreach($recipe->ingredients as $ingredient) {

                            $recipe->ingredients()->detach($ingredient->id);

                            if (count($ingredient->pivot) <= 1 && count($ingredient->lists) === 0) {  

                                $ingredient->delete();
                            } 
                        }
                    
                        $recipe->delete();
                    }

                    return response()->json( [
                        'status' => 'success',
                        'message' => 'recipe was successfuly removed from the list'
                    ], 200);

                }

                return response()->json( [
                    'status' => 'error',
                    'message' => 'The recipe you tried to remove does not exist in this list'
                ], 404);

            }

            return response()->json( [
                'status' => 'unauthorized',
                'message' => 'You are not unauthorized to make changes to this list'
            ], 401);
        }

        return response()->json( [
            'status' => 'error',
            'message' => 'The list you tried to remove a recipe from does not exist'
        ], 404);
    }

    private function checkIfOwnsList($user, $listId )
    {
        
        if($user->lists->where('id', $listId)->first()) {

            return true;
        }

        return false;
    }
}
