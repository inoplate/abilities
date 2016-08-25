<?php

use Inoplate\Abilities\Role;
use Inoplate\Abilities\User;

class UserTest extends TestCase
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

    public function testHasMinimumHit()
    {
        DB::enableQueryLog();
        $user = User::find(1);
        $abilities = $user->abilities;

        $this->assertEquals(
            count(DB::getQueryLog()),
            4
        );

        $abilities = $user->abilities;

        $this->assertEquals(
            count(DB::getQueryLog()),
            4
        );
    }

    public function testRoleIsEagerLoaded()
    {
        $user = User::with('roles')->find(1);

        $this->assertTrue($user->relationLoaded('roles'));
    }

    public function testUserHasAbilities()
    {
        $user = User::find(1);

        $this->assertEquals(
            $user->abilities,
            collect(['create.post', 'update.post', 'remove.post'])
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

        $role = new Role;
        $role->id = 2;
        $role->name = 'Spectator';
        $role->slug = 'spectator';
        $role->description = 'The role for spectator users';
        $role->save();

        $this->assignAbilities($role);

        $user = new User;
        $user->id = 1;
        $user->name = 'admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('123456');
        $user->save();

        $this->assignAbilities($role);

        $user->roles()->attach([1, 2]);
    }

    protected function assignAbilities($role)
    {
        $role->abilities = collect(['create.post', 'update.post', 'remove.post']);
        $role->save();
    }
}