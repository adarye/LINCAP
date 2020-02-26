<?php

namespace App\Http\Controllers;

use App\z7_rta_smur;
use App\z8_rta_smmr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;


class RsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function guardar(Request $request)
    {
        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') || Gate::allows('isJefe') ) {
        $i = 0;
        if ($request->categoria == 'smur') {
            foreach ($request->respuestas as $req) {
                $respuestas = new z7_rta_smur;
                $respuestas->cz7_pp_id = $request->id;
                $respuestas->cz7_rta = $req;
                // $respuestas->cz7_rta_correcta = 'ddd';
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
    }
    public function traerRS($id)
    {
        return z7_rta_smur::where('cz7_pp_id', $id)->get();

    }
    public function update(Request $request)
    {   
        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') || Gate::allows('isJefe') ) {
        for ($i = 0; $i < $request->size; $i++) {
            $respuestas = z7_rta_smur::find($request->respuestas[$i]['cz7_id']);
            $respuestas->cz7_rta = $request->respuestas[$i]['cz7_rta'];
            // $respuestas->cz7_rta_correcta = $request->respuestas[$i]['cz7_rta_correcta'];;
            $respuestas->save();    
         }
         return $i;
        }
    }
    public function updateSMMR(Request $request)
    {   
        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') || Gate::allows('isJefe') ) {
        for ($i = 0; $i < $request->size; $i++) {
            $respuestas =  z8_rta_smmr::find($request->smmr[$i]['cz8_id']);
            $respuestas->cz8_rta = $request->smmr[$i]['cz8_rta'];
            $respuestas->save();    
         }
         return $i;
        }
    }
    public function guardarCorrectaSMUR(Request $request){
        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') || Gate::allows('isJefe') ) {
         z7_rta_smur::select('cz7_pp_id', 'cz8_pp_id' )->where('cz7_pp_id', $request->cz7_pp_id)->update(['cz7_rta_correcta' => $request->cz7_id]);
        }
    }
    public function guardarCorrectaSMMR(Request $request, $opcion){
        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') || Gate::allows('isJefe') ) {
        //  return $request;
       $res =  $request->cz8_id;
        if($opcion == "true"){
            $res = null;
            
        }
       return z8_rta_smmr::select( 'cz8_pp_id')->where('cz8_id', $request->cz8_id)->update(['cz8_rta_correcta' => $res]);
    }
   }
}
