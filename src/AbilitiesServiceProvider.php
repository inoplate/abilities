<?php

namespace Inoplate\Abilities;

use Inoplate\Abilities\Infrastructure\AbilityRepository;
use Inoplate\Abilities\Infrastructure\InMemoryAbility;
use Illuminate\Support\ServiceProvider;

class AbilitiesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrations();
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register(){}

    /**
     * Load migration files
     * 
     * @return void
     */
    public function loadMigrations()
    {
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');
    }
}