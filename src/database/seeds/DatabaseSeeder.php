<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\DeviceData::class, 50)->create();
        factory(App\User::class, 1)->create();
        factory(App\Device::class, 10)->create();
        factory(App\Station::class, 3)->create();
        factory(App\App::class, 1)->create();
    }
}
