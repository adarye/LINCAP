<?php

namespace App\Http\Controllers;

use App\z7_rta_smur;
use App\z5_prueba_preguntas;
use Illuminate\Http\Request;

class RsController extends Controller
{
    public function guardar(Request $request)
    {
        // return $request->respuestas;
        $i = 0;
        foreach ($request->respuestas as $req) {
            $respuestas = new z7_rta_smur;
            $respuestas->cz7_pp_id = $request->id;
            $respuestas->cz7_rta = $req;
            $respuestas->cz7_rta_correcta = 'ddd';
            $i++;
            $respuestas->save();
        }
        return $respuestas;
    }
    public function traerRS($id){
        // return z5_prueba_preguntas::select('cz7_rta')
        // ->join('z7_rta_smurs','z5_prueba_preguntas.cz5_id', '=', 'z7_rta_smurs.cz7_pp_id' )
        // ->z7_rta_smurs
        // ->where('cz5_id',$id)
        // ->where('cz5_categoria','smur')
        // ->get();
        return z7_rta_smur::where('cz7_pp_id', $id)->get();
        
    }
}
