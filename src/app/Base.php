<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Base extends Model
{
    use SoftDeletes;

    public function __construct() {
        parent::__construct();
        $this->hidden[] = 'deleted_at';

    }
}
