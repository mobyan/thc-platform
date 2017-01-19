<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Station;

class StationController extends Controller
{

    static $model = \App\Station::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->_index(['app_id', '=', 1]);
        return  $this->isApi ? $data: view('station', $data);
    }

    public function dashboard($station_id) {
        // devices 
        // values
        $station = Station::with('devices.configs')->find($station_id);
        return $this->view('dashboard', compact('station'));
        // return Station::with('devices.configs')->find($station_id)->getAllDataKeys();
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
        $body['app_id'] = 1;
        return Station::create($body);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $station = $this->_show($id);
        if ($this->isApi) {
            return $station;
        } else {
            // $devices = $station->devices;
            // $station = $station->toArray();
            // $devices = $devices->toArray();
            // var_dump($devices);die();
            return  $this->view('station-info', compact('station'));
        }
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
        Station::destroy($id);
    }
}
