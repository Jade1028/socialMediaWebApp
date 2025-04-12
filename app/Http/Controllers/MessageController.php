<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MessageController extends Controller
{
    //

    /*
        This method will retieve all the messages between the user and the friend but will only display 20 messages per page
    */
    public function index($id)
    {
        $user = auth()->user();

        if($user)
        {
            $friend = User::findOrFail($id);

            if(! Gate::allows('view', [new Message(), $friend->id])){
                abort(403, 'Unauthorized to view messages with this user.');
            }

            $allMessages = Message::where(function($query) use ($user, $id){
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $id);
            })->orWhere(function($query) use ($user, $id){
                $query->where('sender_id', $id)
                    ->where('receiver_id', $user->id);
            })->orderBy('created_at')->paginate(20);

            return view('pages.message', ['messages' => $allMessages, 'friend' => User::find($id)]);
        }
        return redirect()->route('login');
    }

    /*
        Create new message and store in database
    */
    public function create($id, Request $req)
    {
        $user = auth()->user();

        $req->validate([
            'content'=> 'required|string'
        ]);

        if(! Gate::allows('create', Message::class)){
            abort(403, 'Unauthorized to send messages.');
        }

        $message = new Message();
        $message->sender_id = auth()->id();
        $message->receiver_id = $id;
        $message->content = $req->content;
        $message->save();

        return redirect()->back();    //after message sent to backend, return to the same page
    }

    /*
        This method will route the user to the message edition page
    */
    public function edit($id)
    {
        $message = Message::findOrFail($id);

        //Check the authenticated user is the sender of this message
        if(! Gate::allows('edit', $message)){
            abort(403, 'You are not allowed to edit this message.');
        }

        return view('pages.message-edit', ['message'=>$message, 'friend'=>User::find($message->receiver_id)]);
    }

    /*
        This method will update the message with the given id
    */
    public function update(Request $req, $id){
        $message = Message::findOrFail($id);

        //Check the authenticated user is the sender of this message
        if(! Gate::allows('update', $message)){
            abort(403, 'You are not allowed to edit this message.');
        }

        //Check the content is not empty and is string content
        $req->validate([
            'content'=>'required|string'
        ]);

        $message->content = $req->content;
        $message->save();

        return redirect()->route('messages.index', $message->receiver_id)->with('success', 'Message updated successufully');
    }

    /*
        This method will delete the message with the given id
    */
    public function destroy($id){
        $message = Message::findOrFail($id);

        //Check the authenticated user is the sender of this message
        if(! Gate::allows('delete', $message)){
            abort(403, 'You are not allowed to delete this message.');
        }

        $receiverId = $message->receiver_id;
        $message->delete();

        return redirect()->route('messages.index', $receiverId)->with('success', 'Message deleted successfully.');
    }
}
