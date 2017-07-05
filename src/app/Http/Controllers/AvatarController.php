<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\UserProfile;
use Auth;


class AvatarController extends Controller
{
	static $permissions = [
		'all' => ['app_r','app_w','sys_r','sys_w']
	];

	public function store(Request $request) {
		$user = Auth::user();
        $user_profile = $user->user_profile;
		$driver = Storage::drive('upyun');
		$file = $request->files->get('file');
		$path = Storage::putFileAs('avatars', $file, $request->user()->id.'.jpg');
		$avatar_url_relative = '/avatars/'.$request->user()->id.'_'.md5(uniqid()).'.jpg';
		$avatar_url = 'http://thc-platfrom-storage.b0.upaiyun.com'.$avatar_url_relative;
		$driver->write($avatar_url_relative, Storage::get($path));
		$user_profile->avatar_url = $avatar_url;
		$user_profile->save();
		Storage::delete($path);
    }
}
