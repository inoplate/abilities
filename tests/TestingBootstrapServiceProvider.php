<?php

use Inoplate\Abilities\BootstrapServiceProvider;

class TestingBootstrapServiceProvider extends BootstrapServiceProvider
{
    /**
     * Retrieve abilities to be registered
     * 
     * @return array
     */
    protected function getAbilities()
    {
        return ['create.post', 'update.post', 'remove.post', 'huwala.post'];
    }
}