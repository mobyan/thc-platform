<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'app_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function apps()
    {
        return $this->belongsToMany('App\App');
    }

    public function download_jobs()
    {
        return $this->hasMany('App\DownloadJob');
    }
    
    /**
     * has relationship
     * @param  string  $model model name
     * @param  string  $id    object id
     * @return boolean        
     */
    public function has($model, $id) {
        foreach ($this->$model as $instance) {
            if ($instance->id == $id) {
                return true;
            }
        }
        return false;
    }
}
