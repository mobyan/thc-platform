<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class UserApply extends Model {

    protected $table = 'user_apply';

    protected $fillable = ['app_id', 'user_id', 'role_id'];

    /**
     * user
     * @return relation 
     */
    public function user() {
        return $this->belongsTo('\App\User');
    }

    /**
     * app
     * @return relation 
     */
    public function app() {
        return $this->belongsTo('\App\App');
    }

    /**
     * role
     * @return relation 
     */
    public function role() {
        return $this->belongsTo('\App\Role');
    }
}
