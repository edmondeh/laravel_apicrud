<?php

namespace App\Providers;

use App\Interfaces\CommentRepositoryInterface;
use App\Interfaces\PostRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // UserRepository
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        // PostRepository
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        // CommentRepository
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
    }
}
