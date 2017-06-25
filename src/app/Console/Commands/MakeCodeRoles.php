<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Role;
use App\Permission;

class makeCodeRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'code:roles {code_id}';

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
        $code_id = $this->argument('code_id');

        $app_admin = Role::updateOrCreate(['name' => 'app_admin', 'code_id' => $code_id], ['display_name' => '产品线管理员']);
        $app_user = Role::updateOrCreate(['name' => 'app_user', 'code_id' => $code_id], ['display_name' => '产品线用户']);
        $station_admin = Role::updateOrCreate(['name'=> 'station_admin', 'code_id' => $code_id], ['display_name' => '站点管理员']);

        $app_w = Permission::updateOrCreate(['name' => 'app_w']);
        $app_r = Permission::updateOrCreate(['name' => 'app_r']);
        $st_w = Permission::updateOrCreate(['name' => 'st_w']);

        $app_admin->perms()->sync([$app_w->id, $app_r->id]);
        $app_user->perms()->sync([$app_r->id]);
        $station_admin->perms()->sync([$st_w->id]);

    }
}
