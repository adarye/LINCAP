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
        //  return $request[0]['cz7_rta'];
        $i = 0;
        foreach ($request as $req) {
            $respuestas = z7_rta_smur::find($request[$i]['cz7_id']);
            $respuestas->cz7_rta_correcta = 'ddd';
            $respuestas->cz7_rta = $request[$i]['cz7_rta'];;
            $i++;
            $respuestas->save();

        }
    }
}
