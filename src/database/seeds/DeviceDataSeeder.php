<?php

use Illuminate\Database\Seeder;

class DeviceDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\DeviceData::class, 50)->create();
    }
}
