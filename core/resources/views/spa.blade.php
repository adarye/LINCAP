@extends('layouts.base')
@section('content')
 {{-- <keep-alive>  --}}
   <transition name="bounce">
    <router-view :key="$route.fullPath"></router-view>
   </transition>
 {{-- </keep-alive>  --}}
@endsection