<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Ciudades;

use App\Barrios;


class UbicacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
     public function cargarCiudades(){
       return ciudades::select(
             'f013_descripcion',
             'f013_id')
         ->where('f013_id_pais', 169)
         ->where('f013_id_depto', 68)
         ->get();
     }
     public function cargarBarrios($id){
         //return $id;
        return Barrios::select(
            'f014_descripcion',
            'f014_id')
        
        ->where('f014_id_pais', 169)
        ->where('f014_id_depto', 68)
        ->where('f014_id_ciudad', $id)
        ->get();
    
     }
}

