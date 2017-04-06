<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\App;
use App\Role;
use App\Permission;

class MakeApp extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'MakeApp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
    public function fire()
    {
        // create app
        $name = $this->argument('name');
        $app = App::updateOrCreate(['name' => $name]);

        $app_admin = Role::updateOrCreate(['name' => 'app_admin', 'app_id' => $app->id], ['display_name' => '产品线管理员']);
        $app_user = Role::updateOrCreate(['name' => 'app_user', 'app_id' => $app->id], ['display_name' => '产品线用户']);

        $app_w = Permission::updateOrCreate(['name' => 'app_w']);
        $app_r = Permission::updateOrCreate(['name' => 'app_r']);

        $app_admin->perms()->sync([$app_w->id, $app_r->id]);
        $app_user->perms()->sync([$app_r->id]);

        // create roles
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'app name'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }

}
