<?php

namespace App\Http\Controllers;

use App\z7_rta_smur;
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
        return z7_rta_smur::select('cz7_rta')
        ->where('cz7_pp_id',$id)
        ->get();
    }
}
