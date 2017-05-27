<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class App extends Base
{
    protected $table = 'app';

    protected $fillable = ['name', 'regioncode'];

    public function roles() {
        return $this->hasMany('\App\Role');
    }

}
