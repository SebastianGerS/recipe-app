<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Userlist;
use App\User;


class ListController extends Controller
{
    public function store(Request $request) 
    {
        
       
        $user = User::find(auth()->user()->id);
        $list = $user->lists()->create(['name' => $request->name, 'type' => $request->type]);
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'list' => $list
        ]);
    }
}
