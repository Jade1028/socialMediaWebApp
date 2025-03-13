<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userView(){
        return view('pages.users');
    }

    public function search(Request $request){
        $users = User::where('name', 'like', '%'.$request->name.'%')
        ->where('id', '!=', auth()->id())
        ->get();
        return view('pages.users', ['users'=>$users]);
    }
}
