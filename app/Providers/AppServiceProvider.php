<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('App\Repositories\BaseRepositoryInterface', 'App\Repositories\BaseRepository');
        $this->app->bind('App\Repositories\Note\NoteRepositoryInterface', 'App\Repositories\Note\NoteRepository');
        $this->app->bind('App\Repositories\NoteShare\NoteShareInterface', 'App\Repositories\NoteShare\NoteShareRepository');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
