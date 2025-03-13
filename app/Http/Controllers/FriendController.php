<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function index(){
        $friends1 = auth()->user()->friends;
        $friends2 = auth()->user()->friendsOf;
        $friends = $friends1->merge($friends2);
        return view('pages.friends', ['friends'=>$friends]);
    }

    public function store($id){
        $friend = new Friend;
        $friend->user_id1 = auth()->id();
        $friend->user_id2 = $id;
        $friend->status = 'pending';
        $friend->save();

        return back();
    }

}
