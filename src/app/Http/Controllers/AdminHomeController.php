<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;

class AdminHomeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:web');
    }



    public function index(Request $req)
    {
        if($req->user()->app_id!=0){
          \App::abort(403);
        }
        $user = $req->user()->load('roles.permissions', 'codes');
        View::share('user', $user);
        return view('admin-home');
    }
}
