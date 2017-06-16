<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\App;
use App\User;
use App\Role;
use App\Permission;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:init';

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
        //
        $super = Role::updateOrCreate(['name' => 'super'], ['display_name' => '系统管理员']);


        // permissions
        $sys_w = Permission::updateOrCreate(['name' => 'sys_w'], ['display_name' => '系统写']);
        $sys_r = Permission::updateOrCreate(['name' => 'sys_r'], ['display_name' => '系统读']);
        $app_w = Permission::updateOrCreate(['name' => 'app_w'], ['display_name' => '公司写']);
        $app_r = Permission::updateOrCreate(['name' => 'app_r'], ['display_name' => '公司读']);

        $super->perms()->sync([$sys_r->id, $sys_w->id]);

        $user = User::updateOrCreate([
            'name' => 'admin',
            'email' => 'admin@thcreate.com.cn',
            'password' => bcrypt('password'),
        ]);
        $user->roles()->sync([$super->id]);
    }

}
