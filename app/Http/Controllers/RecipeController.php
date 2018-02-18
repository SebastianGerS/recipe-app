<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
                    return response()->json( [
                        'status' => 'success',
                        'recipe' => $recipe
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
        if (!$list->recipes()->where('name', '=', $recipe['name'])) {
            if($list) {
            
                $newRecipe = Recipe::create(['name' => $recipe['name'], 'time' => $recipe['time'], 'img_url' => $recipe['imgUrl'], 'recipe_link' => $recipe['recipeLink']]);
                $newRecipe->lists()->attach($list->id);
                foreach($recipe['cuisines'] as $cuisine) {
                    $filter = Filter::where('name', '=', $cuisine->name)->firstOrFail();
                    $newRecipe->filters()->attach($filter->id);
                    
                }
                foreach($recipe['holidays'] as $holiday) {
                    $filter = Filter::where('name', '=', $holiday->name)->firstOrFail();
                    $newRecipe->filters()->attach($filter->id);

                }
                foreach($recipe['courses'] as $course) {
                    $filter = Filter::where('name', '=', $course->name)->firstOrFail();
                    $newRecipe->filters()->attach($filter->id);
                    
                }
                

            }

            return response()->json( [
                'status' => 'success',
                'recipe' => $newRecipe,
                'message' => "The recipe $newRecipe->name was added to your list!"
            ], 200);

        }
        return response()->json( [
            'status' => 'error',
            'recipe' => $recipe,
            'message' => "The recipe is alredy in your list!"
        ],405);


    }
}
