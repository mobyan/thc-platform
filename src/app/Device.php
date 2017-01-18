<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Base
{
    use SoftDeletes;

    protected $table = 'device';

    protected $fillable = ['station_id'];

}
