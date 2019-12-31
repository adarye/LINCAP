<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\z5_prueba_preguntas;

class PreguntasController extends Controller
{
    public function guardar(Request $request){
       $pregunta = new z5_prueba_preguntas();
       $pregunta->cz5_pregunta = $request->cz5_pregunta;
       $pregunta->cz5_categoria = $request->cz5_categoria;
       $pregunta->cz5_gp_id = $request->cz5_gp_id;
       $pregunta->save();
       return $pregunta;
    }
    public function traerRespuestas($id){

       $ra=  z5_prueba_preguntas::select('cz5_pregunta', 'cz6_pp_id','cz5_categoria')
        ->join(
           'dbo.z6_rta_ra',
           'dbo.z5_prueba_preguntas.cz5_id'
           ,'=',
           'dbo.z6_rta_ra.cz6_pp_id'
        )
        ->where('cz5_gp_id', $id)->get();


        $rs=  z5_prueba_preguntas::select('cz5_pregunta', 'cz5_categoria', 'cz5_id')
        ->where('cz5_gp_id', $id)->get();
        
        return json_encode(array_merge(json_decode( $ra, true),json_decode($rs, true)));
    }
   
}
