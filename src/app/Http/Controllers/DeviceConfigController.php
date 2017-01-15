<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DeviceConfig;

class DeviceConfigController extends Controller
{

    static $model = \App\DeviceConfig::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($station_id, $device_id)
    {
        return $this->_index(['device_id', '=', $device_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $station_id, $device_id)
    {
        $this->validate($request, [
            'data' => 'required',
            'control' => 'required',
            ]);
        $body = $request->all();
        $body['device_id'] = $device_id;
        $body['data'] = json_encode($body['data']);
        $body['control'] = json_encode($body['control']);
        return DeviceConfig::create($body);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($station_id, $device_id, $id)
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
        //
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
}
