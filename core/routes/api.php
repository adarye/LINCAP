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
Route::post('usuario/agregar-todos', 'UsuariosController@registrarTodos');


//LOGIN

Route::post('login/ingresar', 'LoginController@iniciarSesion');

//TABLA EMPLEADOS
//Route::get('empleados/tercero/{id}', 'EmpleadosController@obtenerTercero');

Route::get('empleado/show/{id}' ,'TercerosmmController@show');
Route::post('empleado/update/{id}' ,'TercerosmmController@update');
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
Route::get('gp/{categoria}', 'GPController@index');
Route::get('gp/all/{categoria}', 'GPController@indexAll');
Route::get('gp/buscar/{id}', 'GPController@buscar');
Route::get('preguntas/contar/{id}', 'GPController@contarPreguntas');
Route::post('gp/copiarPrueba', 'GPController@copiarPrueba');

//GESTION PRUEBAS PARA USUARIOS
Route::get('pruebas/pendientes/{id}', 'GPController@traerPendientes');
Route::get('pruebas/completadas/{id}', 'GPController@traerCompletadas');
Route::put('pruebas/finalizar/{id}', 'AsignacionController@finalizarPrueba');
Route::get('pruebas/completadas/estado/{id}', 'RespuestasController@contaRA');

//ASIGNACION PRUEBAS
Route::post('asignacion/guardar', 'AsignacionController@guardar');
Route::post('asignacion/guardarTodos', 'AsignacionController@guardarTodos');
Route::post('asignacion/quitarTodos', 'AsignacionController@quitarTodos');
Route::post('asignacion/delete', 'AsignacionController@delete');
Route::get('asignacion/index/{id}', 'AsignacionController@index');
Route::get('asignacion/contar/{id}','AsignacionController@contar');
Route::get('asignacion/traerNotas/{id}','AsignacionController@conseguirNota');
Route::get('asignacion/estado/{id}/{empleado}','AsignacionController@conseguirEstado');

//PREGUNTA 
Route::post('pregunta/guardar', 'PreguntasController@guardar');
Route::get('pregunta/index/{id}', 'PreguntasController@traerSMUR');
Route::get('respuestaA/buscar/{id}', 'PreguntasController@traerRA');
Route::get('respuestaM/buscar/{id}', 'PreguntasController@traerSMMR');
Route::delete('pregunta/delete/{id}', 'PreguntasController@delete');

Route::get('prueba/inicio/{id_prueba}','RespuestasController@validarInicio');


//RESPUESTAS ABIERTAS
Route::post('respuestaA/guardar', 'RaController@guardar');
Route::put('respuestaA/update', 'PreguntasController@updateRA');


//RESPUESTAS DE SELECCION
Route::post('respuestaS/guardar', 'RsController@guardar');
Route::put('respuestaS/update', 'RsController@update');
Route::put('respuestaS/updateSMMR', 'RsController@updateSMMR');

//GUARDAR RESPUESTAS
Route::post('respuesta/smur/guardar', 'RespuestasController@guardarSMUR');
Route::post('respuesta/smmr/guardar', 'RespuestasController@guardarSMMR');
Route::post('respuesta/ra/guardar', 'RespuestasController@guardarRA');

//BUSCAR RESPUESTAS
Route::get('respuesta/smur/buscar/{id}/{empleado}', 'RespuestasController@traerRespuestasSMUR');
Route::get('respuesta/smmr/buscar/{id}/{empleado}', 'RespuestasController@traerRespuestasSMMR');
Route::get('respuesta/ra/buscar/{id}/{empleado}', 'RespuestasController@traerRespuestasRA');

//NOTICIAS
Route::get('noticias/', 'NoticiasController@index');
Route::post('noticia/guardar', 'NoticiasController@guardar');
Route::post('noticia/actualizar', 'NoticiasController@actualizar');
Route::get('noticia/download-file/{id}', 'NoticiasController@descargar');
Route::delete('noticia/delete/{id}', 'NoticiasController@delete');

//GUARDAR RESPUESTAS CORRECTAS
Route::put('smur/update', 'RsController@guardarCorrectaSMUR');
Route::put('smmr/update/{opcion}', 'RsController@guardarCorrectaSMMR');

//CALIFICAR EVALUACION
Route::get('evaluacion/calificar/{emp}/{id}','RespuestasController@calificar');

Route::put('evaluacion/calificar/RA','RespuestasController@calificaRA');

//ESTADISTICAS
Route::post('estadistica/buscar/smur', 'EstadisticasController@buscarSMUR');
Route::post('estadistica/buscar/smmr', 'EstadisticasController@buscarSMMR');
Route::get('estadistica/cargar/cargos', 'EstadisticasController@cargarCargos');
Route::get('estadistica/resultados/{id}', 'EstadisticasController@Resultados');

