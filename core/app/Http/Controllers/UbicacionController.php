<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Ciudades;

use App\Barrios;

class UbicacionController extends Controller
{
     public function cargarCiudades(){
       return  Ciudades::select(
             'f013_descripcion',
             'f013_id')
         ->where('f013_id_pais', 169)
         ->where('f013_id_depto', 68)
         ->get();
     }
     public function cargarBarrios($id){
         return $id;
     }
}
