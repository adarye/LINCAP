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

Route::get('registros', 'ApiController@traerActivos');

Route::get('registros/retirados', 'ApiController@traerRetirados');
Route::get('registros/InfCorp', 'ApiController@traerInfCorporativa');
//Route::put('empleado/update/{id}' ,'ApiController@update');

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
Route::put('usuario/password', 'UsuariosController@cambiarPassword');
Route::post('usuario/email', 'UsuariosController@enviarEmail');
Route::post('usuario/token', 'UsuariosController@validarToken');
Route::post('usuario/recuperar/password', 'UsuariosController@resetPassword');


//LOGIN

Route::post('login/ingresar', 'LoginController@iniciarSesion');

//TABLA EMPLEADOS
//Route::get('empleados/tercero/{id}', 'EmpleadosController@obtenerTercero');

Route::get('empleado/show/{id}' ,'TercerosmmController@show');
Route::put('empleado/update/{id}' ,'TercerosmmController@update');
Route::get('empleado/{id}', 'TercerosmmController@traerEmpleados');
Route::get('empleado/informacion/{id}', 'TercerosmmController@traerEmpleadoInfo');
 

//CIUDADES Y BARRIOS

Route::get('ciudad', 'UbicacionController@cargarCiudades');
Route::get('barrios/{id}', 'UbicacionController@cargarBarrios');


//CENTRO DE OPERACIONES
Route::get('getCO', 'ApiController@getCO');

//FOTOS
Route::post('usuario/avatar/{id}', 'UsuariosController@myAvatar')->name('avatar');

//GESTION PRUEBAS
Route::post('gp/crear', 'GPController@crear');
Route::put('gp/update', 'GPController@update');
Route::put('gp/cerrar', 'GPController@cerrar');
Route::delete('gp/delete/{id}', 'GPController@delete');
Route::get('gp', 'GPController@index');

//GESTION PRUEBAS PARA USUARIOS
Route::get('pruebas/pendientes/{id}', 'GPController@traerPendientes');

//ASIGNACION PRUEBAS
Route::post('asignacion/guardar', 'AsignacionController@guardar');
Route::get('asignacion/index/{id}', 'AsignacionController@index');
