<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Tms\Repositories\VendorRepositoryInterface', 'Tms\Repositories\DBVendorRepository');
        $this->app->bind('Tms\Repositories\MindstormRepositoryInterface', 'Tms\Repositories\DBMindstormRepository');
        $this->app->bind('Tms\Repositories\MindstormIdeasRepositoryInterface', 'Tms\Repositories\DBMindstormIdeasRepository');
        $this->app->bind('Tms\Repositories\HabitRepositoryInterface', 'Tms\Repositories\DBHabitRepository');
        $this->app->bind('Tms\Repositories\ReadinglistRepositoryInterface', 'Tms\Repositories\DBReadinglistRepository');
        $this->app->bind('Tms\Repositories\ReadinglistNotesRepositoryInterface', 'Tms\Repositories\DBReadinglistNotesRepository');
        $this->app->bind('Tms\Repositories\GoalRepositoryInterface', 'Tms\Repositories\DBGoalRepository');
        $this->app->bind('Tms\Repositories\TaskRepositoryInterface', 'Tms\Repositories\DBTaskRepository');
        $this->app->bind('Tms\Repositories\DailyGoalRepositoryInterface', 'Tms\Repositories\DBDailyGoalRepository');
        $this->app->bind('Tms\Repositories\ProfileRepositoryInterface', 'Tms\Repositories\DBProfileRepository');
    }
}
