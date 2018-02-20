<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ingredient;
use App\Userlist;

class IngredientController extends Controller
{
    public function store(Request $request, Userlist $list)
    {
        $ingredients = $request->ingredients;

        if ($list) {

            if ($this->checkIfOwnsList(auth()->user(), $list->id)) {

                foreach($ingredients as $ingredient) {
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
                            $list->ingredients()->attach($ingredient->id);
                        } else {
                            $list->ingredients()->attach($ingredient[0]->id);
                            
                        }
                        
                    } else {
        
                        $ingredient = Ingredient::firstOrCreate(['name' => $ingredient]);
                        $list->ingredients()->attach($ingredient->id);
                        
                    }         
                }

                return response()->json( [
                    'status' => 'success',
                    'ingredients' => $ingredients,
                    'message' => "The ingredients was added to your list!"
                ], 200);
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
    
    public function destroy(Request $request, Userlist $list, Ingredient $ingredient) 
    {
        if($list && $ingredient) {
            
            if($this->checkIfOwnsList(auth()->user(), $list->id)) {

                $toBeRemoved = $list->ingredients->where('id', $ingredient->id)->first();
            
                if ($toBeRemoved) {

                    $ingredient->lists()->detach($list->id);

                    if (count($ingredient->recipes) === 0 && count($ingredient->lists) === 0) {  

                        $ingredient->delete();
                    } 
                
                    return response()->json( [
                        'status' => 'success',
                        'message' => 'Ingredient was successfuly removed from the list'
                    ], 200);

                }

                return response()->json( [
                    'status' => 'error',
                    'message' => 'The Ingredient you tried to remove does not exist in this list'
                ], 404);

            }

            return response()->json( [
                'status' => 'unauthorized',
                'message' => 'You are not unauthorized to make changes to this list'
            ], 401);
        }

        return response()->json( [
            'status' => 'error',
            'message' => 'The list you tried to remove a ingredient from does not exist'
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
