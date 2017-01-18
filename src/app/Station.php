<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Base
{
    protected $table = 'station';

    protected $fillable = ['app_id'];

    public function devices() {
        return $this->hasMany('App\Device');
    }

}
