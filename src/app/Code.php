<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    //
    protected $table = 'codes';

    public function users(){
        return $this->hasMany('\App\User');
    }

    public function roles() {
        return $this->hasMany('\App\Role');
    }

}
