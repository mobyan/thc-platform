<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class App extends Base
{
    protected $table = 'app';

    protected $fillable = ['name'];

    //public function roles() {
    //    return $this->hasMany('\App\Role');
    //}
    public function users(){
        return $this->hasMany('\App\User');
    }

}
