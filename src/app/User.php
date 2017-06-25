<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Junaidnasir\Larainvite\InviteTrait;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    use InviteTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'app_id','code','phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //public function apps()
    //{
    //    return $this->belongsToMany('App\App');
    //}

    public function codes(){
        return $this->belongsToMany('App\Code');
    }

    public function bcode(){
        return $this->hasOne('App\Code','code','code');
    }
    public function roles(){
        return $this->belongsToMany('App\Role');
    }
    //public function apps_with_regioncode(){
    //    return $this->belongsToMany('App\App')->withPivot('regioncodes');
    //}
    public function download_jobs()
    {
        return $this->hasMany('App\DownloadJob');
    }


    public function user_profile()
    {
        return $this->hasOne('App\UserProfile');
    }

    public function app(){
        return $this->belongsTo('App\App');
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

    public function allows($permission, $requireAll = false)
    {
        //Log::info($permission);
        if (is_array($permission)) {
            foreach ($permission as $permName) {
                $hasPerm = $this->allows($permName, false);

                if ($hasPerm && !$requireAll) {
                    return true;
                } elseif (!$hasPerm && $requireAll) {
                    return false;
                }
            }

            // If we've made it this far and $requireAll is FALSE, then NONE of the perms were found
            // If we've made it this far and $requireAll is TRUE, then ALL of the perms were found.
            // Return the value of $requireAll;
            return $requireAll;
        } else {
            foreach ($this->roles as $role) {
                // Validate against the Permission table
                //if ($role->app_id != $app_id) continue;
                foreach ($role->perms as $perm) {
                    if ($perm->name == $permission) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

}
