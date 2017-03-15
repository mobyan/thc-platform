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
        // roles
        $super = Role::updateOrCreate(['name' => 'super'], ['display_name' => '系统管理员']);
        $app_user = Role::updateOrCreate(['name' => 'app_user'], ['display_name' => '用户']);

        // permissions
        $app_w = Permission::updateOrCreate(['name' => 'app_w'], ['display_name' => '应用写']);
        $app_r = Permission::updateOrCreate(['name' => 'app_r'], ['display_name' => '应用读']);
        $sys_w = Permission::updateOrCreate(['name' => 'sys_w'], ['display_name' => '系统写']);
        $sys_r = Permission::updateOrCreate(['name' => 'sys_r'], ['display_name' => '系统读']);

        // role permission
        $super->perms()->sync([$app_r->id, $app_w->id, $sys_r->id, $sys_w->id]);
        $app_user->perms()->sync([$app_r->id]);

        // user role
        $user = User::where('name','=','yanlong')->first();
        $user->roles()->sync([$super->id]); 
    }
}
