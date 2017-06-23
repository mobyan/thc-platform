<?php namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $fillable = ['name', 'display_name','code_id'];

    public function permissions() {
        return $this->belongsToMany('App\Permission');
    }

    public function code(){
        return $this->belongsTo('App\Code','code_id','id');
    }
}
