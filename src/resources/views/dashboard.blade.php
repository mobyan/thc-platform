@extends('layouts.app')

@section('content')
  <router-link to="/foo">Go to Foo</router-link>
  <router-link to="/bar">Go to Bar</router-link>
  <router-link to="/xx">Go to xx</router-link>
  <router-view></router-view>
@endsection
