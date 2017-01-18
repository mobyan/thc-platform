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
@foreach($tplData['station']->devices as $device)
<p><label>id</label>: {{$device->id}}</p>
@endforeach
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
     @foreach($tplData['station']->devices as $device)
    <p><label>id</label>: {{$device->id}}</p>
    <p><label>created_at</label>: {{$device->created_at}}</p>
    <p><label>updated_at</label>: {{$device->updated_at}}</p>
    @endforeach
</div>
@endsection
