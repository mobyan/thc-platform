<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DeviceData;
use Illuminate\Support\Facades\DB;

class DeviceDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($station_id, $device_id)
    {
        $app_id = 1;
        // $ret = DB::select('select count(*) as cnt from app, station, device where app.id = station.app_id and station.id = device.station_id and app.id = ? and station.id = ? and device.id = ? ', compact('app_id', 'station_id', 'device_id'));
        $sql = "select count(*) as cnt from app, station, device where app.id = station.app_id and station.id = device.station_id and app.id = {$app_id} and station.id = {$station_id} and device.id = ${device_id}";
        $statment = DB::getPDO()->prepare($sql);
        $statment->execute();
        $ret = $statment->fetchAll();
        $cnt = $ret[0]['cnt'];
        if ($cnt != 1) {
            throw new \Exception("Resouce Not Found", 1);
        }
        $items = DeviceData::where('device_id', '=', $device_id)->orderBy('ts', 'asc')->get();
        $count = count($items);
        return compact('count', 'items');
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
