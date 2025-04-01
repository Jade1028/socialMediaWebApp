<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class GroupChatController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();
        if($user)
        {
            $groupChats = $user->groupChats()->with('creator')->get();
            return view('pages.group-chats.index', compact('groupChats'));
        }
        return redirect()->route('login');
    }

}
