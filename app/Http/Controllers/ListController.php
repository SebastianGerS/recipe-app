<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ingredients;
use App\Userlist;
use App\Recipe;
use App\User;


class ListController extends Controller
{
    public function index()
    {   
        $lists = [];

        $user = auth()->user();
        
        foreach($user->lists as $list) {
            if($list->has('recipes')) {
                $list['recipes'] = Recipe::whereHas('lists', function($query) use ($list) {
                    $query->where('id', 'like', $list->id);
                })->get();
            } else {
                $list['ingridients'] = Ingredients::whereHas('lists', function($query) use ($list) {
                    $query->where('id', 'like', $list->id);
                })->get();
            }
           
            array_push($lists, $list);
        }

        return response()->json([
            'status' => 'success',
            'lists' => $lists
        ], 200 );


    }

    public function store(Request $request) 
    {
        $user = User::find(auth()->user()->id);
        $list = $user->lists()->create(['name' => $request->name, 'type' => $request->type]);
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'list' => $list
        ], 201);
    }

    public function destroy(Request $request, Userlist $list)
    {
        if($list) {

            $user = auth()->user();
            $toBeRemoved =  $user->lists->where('id', $list->id)->first();
            
            if ($toBeRemoved) {

                foreach($list->recipes as $recipe) {
                  
                 
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
                }

                $list->delete();

                return response()->json( [
                    'status' => 'success',
                    'message' => 'the list was successfuly removed from the list'
                ], 200);
            }
        }
    }
}
