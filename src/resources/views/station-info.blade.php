@extends('layouts.app')

@section('content')
<div id="head" style="border-bottom: 1px solid #cacfda;margin-bottom: 1em;">
    <div id="header" style="width: 90%;margin: auto;">
      <div id="title">
        <h3>Station 信息</h3>
        <!-- <h3>xxxxxx</h3> -->
    </div>
</div>
</div>
<div class="" style="width: 90%;margin: auto;">
    <p><label>id</label>: {{$tplData['station']->id}}</p>
    <p><label>name</label>: {{$tplData['station']->name}}</p>
    <p><label>type</label>: {{$tplData['station']->type}}</p>
    <p><label>location</label>: {{$tplData['station']->location}}</p>
    <p><label>lat</label>: {{$tplData['station']->lat}}</p>
    <p><label>lon</label>: {{$tplData['station']->lon}}</p>
    <p><label>alt</label>: {{$tplData['station']->alt}}</p>
    <p><label>status</label>: {{$tplData['station']->status}}</p>
</div>
<div id="head" style="border-bottom: 1px solid #cacfda;margin-bottom: 1em;">
    <div id="header" style="width: 90%;margin: auto;">
      <div id="title">
        <h4>Device 列表</h4>
        <!-- <h3>xxxxxx</h3> -->
    </div>
</div>
</div>
<div class="" style="width: 90%;margin: auto;">
    <table class="table table-bordered table-striped table-hover">
        <tr>
            <th>名称</th>
            <th>类型</th>
            <th>公司</th>
            <th>型号</th>
            <th>序列号</th>
            <th>版本</th>
            <th>操作</th>
        </tr>
        @foreach($tplData['station']->devices as $device)
        <tr>
         <td>{{$device->name}}</td>
         <td>{{$device->type}}</td>
         <td>{{$device->company}}</td>
         <td>{{$device->model}}</td>
         <td>{{$device->sn}}</td>
         <td>{{$device->version}}</td>
         <td><a href="/station/{{$tplData['station']->id}}/device/{{$device->id}}"><img height="20" src="https://et.cern.ac.cn/static/images/info.png" class="signal"></a></td>
     </tr>
     @endforeach
 </table>
</div>
@endsection
