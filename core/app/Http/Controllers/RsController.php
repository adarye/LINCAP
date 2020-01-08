<?php

namespace App\Http\Controllers;

use App\z7_rta_smur;
use App\z8_rta_smmr;
use Illuminate\Http\Request;


class RsController extends Controller
{
    public function guardar(Request $request)
    {
        $i = 0;
        if ($request->categoria == 'smur') {
            foreach ($request->respuestas as $req) {
                $respuestas = new z7_rta_smur;
                $respuestas->cz7_pp_id = $request->id;
                $respuestas->cz7_rta = $req;
                $respuestas->cz7_rta_correcta = 'ddd';
                $i++;
                $respuestas->save();
            }
        } else {
            foreach ($request->respuestas as $req) {
                $respuestas = new z8_rta_smmr;
                $respuestas->cz8_pp_id = $request->id;
                $respuestas->cz8_rta = $req;
                $i++;
                $respuestas->save();
            }
        }
        return $respuestas;
    }
    public function traerRS($id)
    {
        return z7_rta_smur::where('cz7_pp_id', $id)->get();

    }
    public function update(Request $request)
    {   
        for ($i = 0; $i < $request->size; $i++) {
            $respuestas =  z7_rta_smur::find($request->respuestas[$i]['cz7_id']);
            $respuestas->cz7_rta_correcta = 'ddd';
            $respuestas->cz7_rta = $request->respuestas[$i]['cz7_rta'];
            $respuestas->save();    
         }
         return $i;
    }
    public function updateSMMR(Request $request)
    {   
       
        for ($i = 0; $i < $request->size; $i++) {
            $respuestas =  z8_rta_smmr::find($request->smmr[$i]['cz8_id']);
            $respuestas->cz8_rta = $request->smmr[$i]['cz8_rta'];
            $respuestas->save();    
         }
         return $i;
    }
}
