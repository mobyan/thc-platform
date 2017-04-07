<?php namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $fillable = ['name', 'display_name', 'app_id'];

    public function permissions() {
        return $this->belongsToMany('App\Permission');
    }
}
