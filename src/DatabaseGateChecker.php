<?php

namespace Inoplate\Abilities;

class DatabaseGateChecker
{
    /**
     * Check if user has ability of given ability
     * 
     * @param  User $user
     * @param  string $ability
     * 
     * @return boolean
     */
    public function check($user, $ability)
    {
        $ability = $user->abilities->first(function($value, $key) use ($ability) {
            return $value === $ability;
        });

        return $ability ? true : false;
    }
}