<?php

namespace App\Providers;

use App\Services\FootballTeamStrategy;
use App\Services\TeamService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TeamService::class, function ($app) {
            return new TeamService();
        });

        $this->app->bind(FootballTeamStrategy::class, function ($app) {
            return new FootballTeamStrategy();
        });

        $this->app->alias(FootballTeamStrategy::class, 'football');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
