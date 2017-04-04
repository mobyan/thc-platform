<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //
    use SoftDeletes;

    protected $table = 'jobs';
}
