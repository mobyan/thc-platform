<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
	protected $table = 'user_profile';

	protected $fillable = ['user_id', 'name', 'position', 'department', 'institution', 
						   'email', 'cell', 'phone', 'address'];

	public function user() {
        return $this->belongsTo('\App\User');
    }
}
