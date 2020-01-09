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
    }
}
