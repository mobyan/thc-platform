<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceConfig extends Model
{
    //
    //
    protected $fillable = ['data', 'control', 'device_id'];

    protected $table = 'device_config';
}
