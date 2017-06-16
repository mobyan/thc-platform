<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Base
{
    protected $table = 'station';

    protected $fillable = ['name', 'type', 'location', 'lon', 'lat', 'alt', 'app_id','regioncode'];

    public function devices() {
        return $this->hasMany('App\Device');
    }
    public function app(){
        return $this->hasOne('App\App','id','app_id');
    }
    public function regionCode(){
      return $this->hasOne('App\RegionCode','code','regioncode');
    }
    public function getAllDataKeys() {
        $keys = [];
        foreach ($this->devices as $device) {
            foreach ($device->configs as $config) {
                $keys = array_merge($keys, array_keys($config->data));
            }
        }
        return $keys;
    }
}
