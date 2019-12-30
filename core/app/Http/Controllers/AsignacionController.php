<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\z4_rel_ts_gp;

class AsignacionController extends Controller
{
    public function guardar(Request $request){
        //return $request->seleccionados;
        
            $relacion = new z4_rel_ts_gp;
            $relacion->cz4_gp_id =  $request->id_prueba;
            $relacion->cz4_ts_id =  $request->id;
            $relacion->save();
       
        return $relacion;
    }
    public function delete(Request $request){
      //return $request->seleccionados;
      $prueba = z4_rel_ts_gp::where('cz4_ts_id', $request->id_ts)->where('cz4_gp_id', $request->id_prueba)->first();
      $prueba->delete();
  }
    public function index($id){
       $registros = z4_rel_ts_gp::select('cz4_ts_id')->where('cz4_gp_id', $id)->get();
      $j =  json_decode($registros, true);
      return $registros;
    }
    public function guardarTodos(Request $request){
       $todos = (array)  $request->activos;
       $i=0; 
       
      foreach ($todos as $req){
        $a = $todos[$i];
          $relacion = new z4_rel_ts_gp;
           $relacion->cz4_gp_id =  $request->id_prueba;
            $relacion->cz4_ts_id =  $a['c0550_rowid_tercero'];
            $i++;
            $relacion->save();
             
      }
      
    
    }
}
