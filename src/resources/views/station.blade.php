@extends('layouts.app')

@section('content')
<div id="head" style="border-bottom: 1px solid #cacfda;margin-bottom: 1em;">
<div id="header" style="width: 90%;margin: auto;">
  <div id="title">
    <h3>Station 列表</h3>
    <!-- <h3>xxxxxx</h3> -->
  </div>
</div>
</div>
<div class="" style="width: 90%;margin: auto;">
  <table class="table table-bordered table-striped table-hover">
    <tr class="fatal">
      <th>名称</th>
      <th>类型</th>
      <th>地址</th>
      <th>状态</th>
      <th>操作</th>
    </tr>
  @foreach ($items as $item)
    <tr class="">
      <!-- <td>{{ $item->id }}</td> -->
      <td>{{ $item->name }}</td>
      <td>{{ $item->type }}</td>
      <td>{{ $item->location }}</td>
      <td><img height="20" src="https://et.cern.ac.cn/static/images/3.png" class="signal"></td>
      <td><a href="/station/{{$item->id}}"><img height="20" src="https://et.cern.ac.cn/static/images/info.png" class="signal"></a></td>
    </tr>
  @endforeach
  </table>
</div>
@endsection
