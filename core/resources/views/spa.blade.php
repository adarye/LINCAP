@extends('layouts.base')
@section('content')
 {{-- <keep-alive>  --}}
   <transition  name="fade" mode="out-in">
    <router-view :key="$route.fullPath"></router-view>
   </transition>
  
 {{-- </keep-alive>  --}}
@endsection