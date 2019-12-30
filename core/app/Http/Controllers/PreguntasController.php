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
    }
}
