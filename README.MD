## Inoplate abilities loader
Inoplate abilities loader is a laravel package to load and check abilities from database.

## Instalation
> composer install inoplate/abilities

## Usage
Before we can use this package, we must follow several step below.
    
1. Add ***Inoplate\Abilities\AbilitiesServiceProvider*** to our providers configuration.
2. Replate providers for ***Illuminate\Auth\AuthServiceProvider*** with ***Inoplate\Abilities\AuthServiceProvider***

To register abilities, we can extend BootstrapServiceProvider that shipped with this package. Define availabe abilities in the **getAbilities** method

```php

    use Inoplate\Abilities\BootstrapServiceProvider as BaseProvider;

    class BootstrapServiceProvider extends BaseProvider
    {
        protected function getAbilities()
        {
            // Abilities are developer defined entity. Yess!
            // You must define abilities that are available for checking
            return ['create-post', 'update-post', 'delete-post'];
        }
    }

```
This package shipped with default migrations. You can publish and use it or use something else based with what you need. This package also shipped with **User** and **Role** model that has abilities property. And again you are free to use it or not. (User an Role are N:N in relationship)

```php
    $user->abilities; // Retrieve user abilities
    $user->roles->abilities; // Retrieve user specific role abilities
    
    // To assign abilities, use Role. 
    // Unfortunately, we can't set abilities directly to user at the moment.
    // NOTE! Abilities assignment will override existing abilities.
    
    $role = Role::find(1);
    $role->abilities = ['new-abilities'];
    $role->save();
```

Every time we  check ability like **$user->can('create-post')** or **Gate::allows('create-post')**, it will check the abilities that belongs to User.

Policy is a resource based check, we can use it as usual.

**Please Note.**

1. If you use custom Gate checker, there will be one additional parameters that is **ability** to check.
    
**Running the tests**

> vendor/bin/phpunit

**Contribution**

Thank you for considering contributing to the this package. Just create pull request to and elaborate your purpose. We can discuss about the coding standart, branching strategy, etc.

**License**

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT)