<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Station;
use Entrust;
use DB;
use Auth;

class StationController extends Controller
{

    static $model = \App\Station::class;

    static $permissions = [
    'all' => ['app_w','sys_w'],
    'index' => ['app_r','sys_r'],
    'show' => ['app_r','sys_r'],
    'update' => ['app_w', 'sys_w'],
    'store' =>['app_w','sys_w']
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        if($req->input('app_id')){
          return $this->_index(['app_id','=',$req->input('app_id')]);
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
        $this->validate($request, [
            ]);
        $body = $request->all();
        if(!$body['app_id']){
          $body['app_id'] = $request->user()->app_id;
        }
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
        $this->validate($request, [
            ]);
        $data = $request->all();
        if(!$data['app_id']){
          $data['app_id'] = $request->user()->app_id;
        }
        return $this->_update($id, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->_destroy($id);
    }

}
