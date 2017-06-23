<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{

    static $model = \App\User::class;

    static $permissions = [
    'all' => ['sys_r'],
    'update' => ['app_r', 'sys_w'],
    'store' => ['sys_w'],
    'my' => ['app_r'],
    'index' => ['sys_w'],
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
        $this->validate($request, [
            ]);
        $body = $request->all();

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
    }

    public function my(Request $req) {
        $this->assertPermissions('my');
        return $req->user()->load('roles.permissions', 'apps');
    }

    public function attach(Request $req){
        $this->assertPermissions('attach');
        User::find($req['user_id'])->roles()->attach($req['role_id']);
        User::find($req['user_id'])->codes()->attach($req['code_id']);
    }

    public function detach(Request $req){
        $this->assertPermissions('detach');
        User::find($req['user_id'])->roles()->detach($req['role_id']);
        User::find($req['user_id'])->codes()->detach($req['code_id']);
    }
}
