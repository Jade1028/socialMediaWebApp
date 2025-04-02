<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // Fetch friendships where the user is either user_id1 or user_id2
        // $friendships = Friend::where('user_id1', $userId)
        //                      ->orWhere('user_id2', $userId)
        //                      ->get();

        $f1 = auth()->user()->friends;
        $f2 = auth()->user()->friendsOf;
        $friendships = $f1->merge($f2);


        // Filter the friendships by status
        $accepted = $friendships->where('status', 'accepted');
        $pending = $friendships->where('status', 'pending');

        // Extract the actual friends (other user in the friendship)
        $acceptedFriends = $accepted->map(function ($friendship) use ($userId) {
            return $friendship->user_id1 == $userId ? $friendship->user2 : $friendship->user1;
        })->filter();

        // Extract the friend requests sent to the user
        $pendingFriends = $pending->map(function ($friendship) use ($userId) {
            if ($friendship->user_id2 == $userId) {
                return $friendship->user1;
            }
        })->filter();

        return view('pages.friends', ['acceptedFriends' => $acceptedFriends, 'pendingFriends' => $pendingFriends]);
    }

    /**
     * Gotcha: user_id1 is always the sender
     * Gotcha: user_id2 is always the receiver
     */
    public function store($id)
    {
        $friend = new Friend;
        $friend->user_id1 = auth()->id();
        $friend->user_id2 = $id;
        $friend->status = 'pending';
        $friend->save();

        return back();
    }

    // accept friend request
    public function accept($id)
    {
        $friend = Friend::where('user_id1', $id)
            ->where('user_id2', auth()->id())
            ->first();

        $friend->status = 'accepted';
        $friend->save();

        return back();
    }

    // reject friend request
    public function reject($id)
    {
        $friend = Friend::where('user_id1', $id)
            ->where('user_id2', auth()->id())
            ->first();

        $friend->delete();

        return back();
    }

    // unfriend function
    public function destroy($id)
    {
        Friend::where('user_id1', $id)
            ->where('user_id2', auth()->id())
            ->orWhere(function ($query) use ($id) {
                $query->where('user_id1', auth()->id())
                    ->where('user_id2', $id);
            })->delete();

        return back();
    }
}
