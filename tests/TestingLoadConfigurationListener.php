<?php

use Illuminate\Foundation\Application;

class TestingLoadConfigurationListener
{
    /**
     * Handle the event.
     *
     * @param  Application  $app
     * @return void
     */
    public function handle(Application $app)
    {
        $providers = $app['config']->get('app.providers');
        $key = array_search(Illuminate\Auth\AuthServiceProvider::class, $providers);

        $providers[$key] = Inoplate\Abilities\AuthServiceProvider::class;
        $providers[] = TestingBootstrapServiceProvider::class;

        $app['config']->set('app.providers', $providers);
        $app['config']->set('auth.providers.users.model', Inoplate\Abilities\User::class);
    }
}