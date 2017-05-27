<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppUser extends Base
{
    //
    use SoftDeletes;

    protected $table = 'app_user';

    protected $fillable = ['user_id', 'app_id', 'regioncode_ids'];


}
