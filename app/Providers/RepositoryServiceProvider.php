<?php

namespace App\Providers;

use App\Repositories\BlogRepository;
use App\Repositories\CommentRepository;
use App\Repositories\Interfaces\BlogInterface;
use App\Repositories\Interfaces\CommentInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register Interface and Repository in here
        // You must place Interface in first place
        // If you don't, the Repository will not get read.

        $this->app->bind(
            BlogInterface::class,
            BlogRepository::class
        );

        $this->app->bind(
            CommentInterface::class,
            CommentRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
