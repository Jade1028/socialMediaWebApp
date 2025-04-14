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
    public function show($id)
    {
        $user = auth()->user();
        $friend = User::findOrFail($id);
    
        // Check authorization for viewing conversation
        $this->authorize('viewConversation', [Message::class, $id]);
        
        $allMessages = Message::where(function($query) use ($user, $id){
            $query->where('sender_id', $user->id)
                ->where('receiver_id', $id);
        })->orWhere(function($query) use ($user, $id){
            $query->where('sender_id', $id)
                ->where('receiver_id', $user->id);
        })->orderBy('created_at')->paginate(20);
    
        return view('pages.message', ['messages' => $allMessages, 'friend' => $friend]);
    }

    /*
        Create new message and store in database
    */
    public function create($id, Request $req)
    {
        $user = auth()->user();

        $this->authorize('create', [Message::class, $id]);

        $req->validate([
            'content'=> 'required|string'
        ]);

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

        $this->authorize('edit', $message);

        return view('pages.message-edit', ['message'=>$message, 'friend'=>User::find($message->receiver_id)]);
    }

    /*
        This method will update the message with the given id
    */
    public function update(Request $req, $id)
    {
        $message = Message::findOrFail($id);

        $this->authorize('update', $message);

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
    public function destroy($id)
    {
        $message = Message::findOrFail($id);

        $this->authorize('destroy', $message);

        $receiverId = $message->receiver_id;
        $message->delete();

        return redirect()->route('messages.index', $receiverId)->with('success', 'Message deleted successfully.');
    }
}
