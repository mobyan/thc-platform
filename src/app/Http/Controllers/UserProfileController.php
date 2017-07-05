<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UserProfile;
use Auth;

class UserProfileController extends Controller
{
    static $model = \App\UserProfile::class;

	static $permissions = [
		'all' => ['app_r'],
	];

	public function index()
	{
        $user = Auth::user();
        $user_profile = $user->user_profile;
        if($user_profile) {
        	return compact('user_profile');
        }
        else {
        	$user_profile = new UserProfile;
        	$user_profile->user_id = $user->id;
        	$user_profile->name = $user->name;
        	$user_profile->position = 'default';
        	$user_profile->department = 'default';
        	$user_profile->institution = 'default';
        	$user_profile->email = $user->email;
        	$user_profile->cell = 'default';
        	$user_profile->phone = 'default';
        	$user_profile->address = 'default';
            $user_profile->avatar_url = '/image/upic.png';
        	$user_profile->save();
        	return compact('user_profile');
        }
    }

    public function update(Request $request, $id)
    {
    	$user = Auth::user();
    	$user_profile = $user->user_profile;
    	$user_profile->name = $request->input('name');
    	$user_profile->position = $request->input('position');
    	$user_profile->department = $request->input('department');
    	$user_profile->institution = $request->input('institution');
    	$user_profile->email = $request->input('email');
    	$user_profile->cell = $request->input('cell');
    	$user_profile->phone = $request->input('phone');
    	$user_profile->address = $request->input('address');
    	$user_profile->save();
    }
}
