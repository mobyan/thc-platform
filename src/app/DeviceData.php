<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeviceData extends Model
{
    //
    protected $table = 'device_data';

    public function getDataAttribute($value) {
        return json_decode($value, true);
    }

    public function config() {
        return $this->belongsTo('App\DeviceConfig', 'device_config_id');
    }
}
