<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\z3_gestion_pruebas;

class GPController extends Controller
{
    public function crear(Request $request){
        $prueba = new z3_gestion_pruebas();
        $prueba->cz3_nombre =  $request->cz3_nombre;
        $prueba->cz3_descripcion =  $request->cz3_descripcion;
        $prueba->cz3_categoria = 1;
        $prueba->cz3_id_creador = Auth()->user()->cz1_id;
        $prueba->cz3_fecha_apertura = $request->cz3_fecha_apertura;
        $prueba->cz3_fecha_cierre = $request->cz3_fecha_cierre;
        $prueba->save();

        return $prueba;
    }

    public function index(){
        
      return z3_gestion_pruebas::all()->where('cz3_id_creador',  Auth()->user()->cz1_id);
    }
    public function update(Request $request){
       
        $prueba = z3_gestion_pruebas::find($request->cz3_id);
        $prueba->cz3_nombre =  $request->cz3_nombre;
        $prueba->cz3_descripcion =  $request->cz3_descripcion;
        $prueba->cz3_fecha_apertura = $request->cz3_fecha_apertura;
        $prueba->cz3_fecha_cierre = $request->cz3_fecha_cierre;
        $prueba->save();

        return $prueba;
    }
}
