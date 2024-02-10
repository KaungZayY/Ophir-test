<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('edit-delete-post', function(User $user, Post $post){
            return $user->id === $post->user_id 
                            ? Response::allow() 
                            : Response::deny("Forbidden");
        });

        Gate::define('edit-comment', function(User $user, Comment $comment){
            return $user->id === $comment->user_id 
                            ? Response::allow() 
                            : Response::deny("Forbidden");
        });

        Gate::define('delete-comment', function(User $user, Comment $comment, Post $post){
            return $user->id === $comment->user_id || $user->id === $post->user_id
                            ? Response::allow() 
                            : Response::deny("Forbidden");
        });
    }
}
