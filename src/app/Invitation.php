<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitation extends Model
{
    use SoftDeletes;
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_invitations';

    /**
     * Referral User
     */
    public function user()
    {
        return $this->belongsTo(config('larainvite.UserModel'));
    }

    public function app(){
        return $this->hasOne('App\App','id','app_id');
    }

    public function rcode(){
      return $this->hasOne('App\Code', 'code','regioncode');
    }
}
