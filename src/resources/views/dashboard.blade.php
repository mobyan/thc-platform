@extends('layouts.app')

@section('content')
<div id="head" style="border-bottom: 1px solid #cacfda;margin-bottom: 1em;">
<div id="header" style="width: 90%;margin: auto;">
  <div id="title">
    <h3>Station 列表</h3>
  </div>
</div>
</div>

<div class="" style="width: 90%;margin: auto;">

selectd: @{{ selectedDevice }}
<select class="form-control" v-model="selectedDevice">
  <option v-for="(device,k) in devices" :value="k" >@{{ device.name }}</option>
</select>
<ul>
  <highcharts v-for="chart in charts" :options="chart" ref="highcharts"></highcharts>
</ul>
<div>@{{ JSON.stringify(datas, null, 4) }}</div>
</div>
    <router-link to="/foo">Go to Foo</router-link>
    <router-link to="/bar">Go to Bar</router-link>
      <router-view></router-view>


@endsection
