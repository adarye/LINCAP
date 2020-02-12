@extends('layouts.base')
@section('content')

   <transition  name="fade" mode="out-in">
    <router-view :key="$route.fullPath"></router-view>
   </transition>
  
@endsection