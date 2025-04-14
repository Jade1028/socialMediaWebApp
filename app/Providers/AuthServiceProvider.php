<?php

namespace App\Providers;

use App\Models\Friend;
use App\Models\Post;
use App\Models\User;
use App\Models\Message;
use App\Models\Comment;
use App\Policies\CommentPolicy;
use App\Policies\FriendPolicy;
use App\Policies\PostPolicy;
use App\Policies\ProfilePolicy;
use App\Policies\MessagePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Post::class => PostPolicy::class,
        Friend::class => FriendPolicy::class,
        Comment::class => CommentPolicy::class,
        Message::class => MessagePolicy::class,
        User::class => ProfilePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
