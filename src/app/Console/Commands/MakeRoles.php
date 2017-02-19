<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Role;
use App\User;
use App\Permission;

class MakeRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MakeRoles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo 'fff';
        $admin = new Role;
        $admin->name = 'Admin';
        $admin->save();

        // $owner = new Role;
        // $owner->name = 'Owner';
        // $owner->save();
        // $manageUsers = new Permission;
        // $manageUsers->name = 'manage_users';
        // $manageUsers->display_name = 'Manage Users';
        // $manageUsers->save();

        $managePosts = new Permission;
        $managePosts->name = 'manage_posts';
        $managePosts->display_name = 'Manage Posts';
        $managePosts->save();

        // $owner->perms()->sync(array($managePosts->id, $manageUsers->id));
        $admin->perms()->sync(array($managePosts->id));

        $user = User::where('name','=','yanlong')->first();

        $user->attachRole( $admin ); 
        // $user->roles()->attach( $admin->id ); // id only
    }
}
