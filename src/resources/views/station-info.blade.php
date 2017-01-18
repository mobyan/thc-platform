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
@foreach($data as $k => $v)
<p><label>{{$k}}</label>: {{$v}}</p>
@endforeach
</div>
@endsection
