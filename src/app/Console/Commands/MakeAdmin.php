<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\App;
use App\User;
use App\Role;
use App\Permission;
use App\UserProfile;

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
        $super = Role::updateOrCreate(['name' => 'super', 'code_id' => 0], ['display_name' => '系统管理员']);


        // permissions
        $sys_w = Permission::updateOrCreate(['name' => 'sys_w'], ['display_name' => '系统写']);
        $sys_r = Permission::updateOrCreate(['name' => 'sys_r'], ['display_name' => '系统读']);

        $super->perms()->sync([$sys_r->id, $sys_w->id]);

        $user = User::updateOrCreate([
            'name' => 'admin',
            'email' => 'admin@thcreate.com.cn',
            'phone' => '13466654933',
            'app_id' => 0,
            'code' => '0',
            'password' => bcrypt('password'),
        ]);
        $user->roles()->sync([$super->id]);
<<<<<<< HEAD

=======
>>>>>>> a5463e375bbf13adbc68a10724366cfb3ce5aef2
        $user_profile = new UserProfile;
        $user_profile->user_id = $user->id;
        $user_profile->name = $user->name;
        $user_profile->position = 'default';
        $user_profile->department = 'default';
        $user_profile->institution = 'default';
        $user_profile->email = $user->email;
        $user_profile->cell = 'default';
        $user_profile->phone = 'default';
        $user_profile->address = 'default';
        $user_profile->avatar_url = '/image/upic.png';
        $user_profile->save();
    }

}
