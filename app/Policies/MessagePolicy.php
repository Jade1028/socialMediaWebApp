<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Message $message, int $friendId)
    {
        //Check the sender user id and the receiver user id 
        return $user->id === auth()->id() && ($message->sender_id === $user->id && $message->receiver_id === $friendId) || ($message->sender_id === $friendId && $message->receiver_id === $user->id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //Check if the user authenticated, if yes he/she can send message
        return auth()->check();   
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Message $message)
    {
        //Check if the user is the sender to edit the message
        return $user->id === $message->sender_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Message $message)
    {
        //Check if the user is the sender to delete the message
        return $user->id === $message->sender_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function edit(User $user, Message $message)
    {
        //Check if the message sender is same as the user intended to change the message
        return $user->id === $message->sender_id;
    }
}
