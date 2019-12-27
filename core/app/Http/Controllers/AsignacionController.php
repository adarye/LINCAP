<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\z4_rel_ts_gp;

class AsignacionController extends Controller
{
    public function guardar(Request $request){
        // return $request->seleccionados;
        foreach($request->seleccionados as $req){
            $relacion = new z4_rel_ts_gp;
            $relacion->cz4_gp_id =  $request->id_prueba;
            $relacion->cz4_ts_id =  $req;
            $relacion->save();
          }
       
        return $relacion;
    }
    public function index($id){
       $registros = z4_rel_ts_gp::select('cz4_ts_id')->where('cz4_gp_id', $id)->get();
      $j =  json_decode($registros, true);
      return $registros;
    }
}
