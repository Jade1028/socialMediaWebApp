<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function index() {
        $userId = auth()->id();
    
        // Fetch friendships where the user is either user_id1 or user_id2
        $friendships = Friend::where('user_id1', $userId)
                             ->orWhere('user_id2', $userId)
                             ->get();
    
        // Extract the actual friends (other user in the friendship)
        $friends = $friendships->map(function ($friendship) use ($userId) {
            return $friendship->user_id1 == $userId ? $friendship->user2 : $friendship->user1;
        });
    
        return view('pages.friends', ['friends' => $friends]);
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
