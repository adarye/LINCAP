<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/login', 'PagesController@login')->name('login');
Route::post('login/salir', 'LoginController@logout')->name('logout');
Route::get('/{any?}',function(){return view('spa');})->where('any','.*')->name('index')->middleware('auth');

