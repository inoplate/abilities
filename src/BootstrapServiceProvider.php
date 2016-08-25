<?php

namespace Inoplate\Abilities;

use Gate;
use Illuminate\Support\ServiceProvider;

abstract class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     * 
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerAbilities();
    }

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    public function registerAbilities()
    {
        $abilities = $this->getAbilities();

        foreach ($abilities as $ability) {
            Gate::define($ability, 'Inoplate\Abilities\DatabaseGateChecker@check');
        }
    }

    /**
     * Retrieve abilities to be registered
     * 
     * @return array
     */
    protected function getAbilities()
    {
        return [];
    }
}
