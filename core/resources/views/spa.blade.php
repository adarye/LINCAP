@extends('layouts.base')
@section('content')
 {{-- <keep-alive>  --}}
     
    <router-view :key="$route.fullPath"></router-view>
     
 {{-- </keep-alive>  --}}
@endsection