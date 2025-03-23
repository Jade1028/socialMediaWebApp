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

        // Filter the friendships to only include accepted ones
        $accepted = $friendships->where('status', 'accepted');
        $pending = $friendships->where('status', 'pending');

        // Extract the actual friends (other user in the friendship)
        $acceptedFriends = $accepted->map(function ($friendship) use ($userId) {
            return $friendship->user_id1 == $userId ? $friendship->user2 : $friendship->user1;
        });

        $pendingFriends = $pending->map(function ($friendship) use ($userId) {
            return $friendship->user_id1 == $userId ? $friendship->user2 : $friendship->user1;
        });
    
        return view('pages.friends', ['acceptedFriends' => $acceptedFriends, 'pendingFriends'=> $pendingFriends]);
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
