<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('registros', 'ApiController@index');
Route::get('/show/{id}' ,'ApiController@show');

//CRUD DE LA TABLA ROLES

Route::get('roles', 'RolesController@index');
Route::get('roles/show/{id}', 'RolesController@show');
Route::put('roles/update/{cz2_id}', 'RolesController@update');
Route::post('roles/create', 'RolesController@create');
Route::delete('roles/delete/{id}', 'RolesController@delete');

//CRUD DE LA TABLA USUARIOS

Route::get('usuarios', 'UsuariosController@index');
Route::post('usuarios/create', 'UsuariosController@create');
Route::get('usuarios/verificar/{id}', 'ApiController@buscarTercero');
Route::delete('usuarios/delete/{id}', 'UsuariosController@delete');
Route::put('usuarios/update/{id}', 'UsuariosController@update');