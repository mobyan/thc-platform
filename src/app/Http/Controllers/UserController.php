<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;


class UserController extends Controller
{

    static $model = \App\User::class;

    static $permissions = [
    'all' => ['sys_r'],
    'update' => ['app_w', 'sys_w'],
    'store' => ['sys_w','app_w'],
    'my' => ['app_r'],
    'show' => ['app_w','sys_w'],
    'index' => ['sys_w', 'app_w'],
    'destroy' => ['sys_w','app_w'],
    'attach' => ['app_w', 'sys_w'],
    'detach' => ['app_w', 'sys_w'],
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if($request->input('app_id')){
        return $this->_index(['app_id','=',$request->input('app_id')]);
      }

      return $this->_index();
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validator($request->all());

        $body = $request->all();
        $body['password']= bcrypt($body['password']);
        return $this->_store($body);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        //$user = $this->_show($id);
        //return $user->load('roles.code');
        return $this->_show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->input('roles')) {
            Auth::user()->roles()->sync($request->input('roles'));
        }
        return $this->_update($id, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return $this->_destroy($id);
    }

    public function my(Request $req) {
        $this->assertPermissions('my');
        return $req->user()->load('roles.permissions', 'apps');
    }

    public function attach(Request $req){
        $this->assertPermissions('attach');
        $user = static::$model::find($req['user_id']);
        if(count($user->roles()->where('id',$req['role_id'])->get()) == 0){
          static::$model::find($req['user_id'])->roles()->attach($req['role_id']);
        }
        if(count($user->codes()->where('id',$req['code_id'])->get()) == 0){
          static::$model::find($req['user_id'])->codes()->attach($req['code_id']);
        }

        $user = static::$model::with('roles.code')->find($req['user_id']);
        //$user->load('roles.code');
        return $user;
    }

    public function detach(Request $req){
        $this->assertPermissions('detach');
        static::$model::find($req['user_id'])->roles()->detach($req['role_id']);
        static::$model::find($req['user_id'])->codes()->detach($req['code_id']);
        //$user = static::$model::load('roles.code');

        //return $user;
    }
}
