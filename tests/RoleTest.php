<?php

use Inoplate\Abilities\Role;

class RoleTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        Artisan::call('vendor:publish', 
            [
                '--provider' => 'Inoplate\Abilities\AbilitiesServiceProvider', 
                '--tag' => 'migrations'
            ]
        );
        
        Artisan::call('migrate');
        $this->setupDb();
    }

    public function testRoleCanStoreAbilities()
    {
        $admin = Role::find(1);
        $admin->abilities = collect(['create.post', 'update.post']);
        $admin->save();

        $admin = Role::find(1);
        $this->assertEquals(
            $admin->abilities,
            collect(['create.post', 'update.post'])
        );

        $admin->abilities = collect(['create.post', 'update.post', 'remove.post']);
        $admin->save();

        $admin = Role::find(1);
        $this->assertEquals(
            $admin->abilities,
            collect(['create.post', 'update.post', 'remove.post'])
        );
    }

    public function testRoleHasAbilities()
    {
        $admin = Role::find(1);
        $spectator = Role::find(2);

        $this->assertEquals(
            $admin->abilities,
            collect(['create.post', 'update.post', 'remove.post'])
        );

        $this->assertEquals(
            $spectator->abilities,
            collect([])
        );
    }

    protected function tearDown()
    {
        Artisan::call('migrate:reset');

        parent::tearDown();
    }

    public function createApplication()
    {
        $app = require __DIR__.'/bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    protected function setupDb()
    {        
        $role = new Role;
        $role->id = 1;
        $role->name = 'Administrator';
        $role->slug = 'administrator';
        $role->description = 'The role for administrator users';
        $role->save();

        $this->assignAbilities($role);

        $role = new Role;
        $role->id = 2;
        $role->name = 'Spectator';
        $role->slug = 'spectator';
        $role->description = 'The role for spectator users';
        $role->save();
    }

    protected function assignAbilities($role)
    {
        $role->abilities = collect(['create.post', 'update.post', 'remove.post']);
        $role->save();
    }
}