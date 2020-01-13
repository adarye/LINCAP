<?php

namespace App\Http\Controllers;

use App\z5_prueba_preguntas;
use Illuminate\Http\Request;

class PreguntasController extends Controller
{
    public function guardar(Request $request)
    {
        $pregunta = new z5_prueba_preguntas();
        $pregunta->cz5_pregunta = $request->cz5_pregunta;
        $pregunta->cz5_categoria = $request->cz5_categoria;
        $pregunta->cz5_gp_id = $request->cz5_gp_id;
        $pregunta->save();
        return $pregunta;
    }
<<<<<<< HEAD
<<<<<<< HEAD
    public function traerRespuestas($id){

      //  $ra=  z5_prueba_preguntas::select('cz5_pregunta', 'cz6_pp_id','cz5_categoria')
      //   ->join(
      //      'dbo.z6_rta_ra',
      //      'dbo.z5_prueba_preguntas.cz5_id'
      //      ,'=',
      //      'dbo.z6_rta_ra.cz6_pp_id'
      //   )
      //   ->where('cz5_gp_id', $id)->get();


        return z5_prueba_preguntas::respuestas()->get();
        
      //   return json_encode(array_merge(json_decode( $ra, true),json_decode($rs, true)));
        // return z5_prueba_preguntas::where('cz5_id')->z7_rta_smur;
=======
    public function traerSMUR($id){
        return z5_prueba_preguntas::with('respuestas')
        ->where('cz5_gp_id', $id)
        ->where('cz5_categoria', 'smur')
        ->get();
>>>>>>> 53d491668783f12a86a0fb3f26782ccaba67d472
=======
    public function traerSMUR($id)
    {
        return z5_prueba_preguntas::with('respuestas')
            ->where('cz5_gp_id', $id)
            ->where('cz5_categoria', 'smur')
            ->get();
    }
    public function traerRA($id)
    {
        return z5_prueba_preguntas::select('cz6_id', 'cz5_pregunta', 'cz5_categoria', 'cz5_id')->
            join(
            'z6_rta_ra',
            'z5_prueba_preguntas.cz5_id',
            '=',
            'z6_rta_ra.cz6_pp_id'
        )->where('cz5_gp_id', $id)->get();
    }
    public function traerSMMR($id)
    {
        return z5_prueba_preguntas::with('smmr')
            ->where('cz5_gp_id', $id)
            ->where('cz5_categoria', 'smmr')
            ->get();
    }
    public function updateRA(Request $request)
    {
        $ra = z5_prueba_preguntas::find($request->cz5_id);
        $ra->cz5_pregunta = $request->cz5_pregunta;
        $ra->save();
        return $ra;
    }
    public function delete($id)
    {
        $pregunta = z5_prueba_preguntas::find($id);
        $pregunta->delete();
>>>>>>> 2c7a0c840481d9db16e42bd82dde118487134813
    }
}
