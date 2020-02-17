<?php

namespace App\Http\Controllers;

use App\z5_prueba_preguntas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\z4_rel_ts_gp;
use Carbon\Carbon;

class PreguntasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function guardar(Request $request)
    {
        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') ) {
        $pregunta = new z5_prueba_preguntas();
        $pregunta->cz5_pregunta = $request->cz5_pregunta;
        $pregunta->cz5_categoria = $request->cz5_categoria;
        $pregunta->cz5_gp_id = $request->cz5_gp_id;
        $pregunta->cz5_n_rtas = $request->cz5_n_rtas;
        $pregunta->cz5_n_rtas_correctas = $request->cz5_n_rtas_correctas;
        $pregunta->save();
        return $pregunta;
        }
    }

    public function traerSMUR($id){
       $empleado = z4_rel_ts_gp::all()->where('cz4_gp_id', $id)->where('cz4_ts_id', Auth()->user()->cz1_id_empleado)->first();
       if($empleado != null || Gate::allows('isAdmin') || 
       Gate::allows('isRRHH') || Gate::allows('isSST')){
        return z5_prueba_preguntas::with('respuestas')
        ->where('cz5_gp_id', $id)
        ->where('cz5_categoria', 'smur')
        ->get();
        }
        
        
    }
    public function traerRA($id)
    {
        $empleado = z4_rel_ts_gp::all()->where('cz4_gp_id', $id)->where('cz4_ts_id', Auth()->user()->cz1_id_empleado)->first();
        if($empleado != null || Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST')){
        return z5_prueba_preguntas::select( 'cz5_pregunta', 'cz5_categoria', 'cz5_id', 'cz5_gp_id')->
           where('cz5_gp_id', $id)->where('cz5_categoria', 'ra')->orderBy('cz5_id', 'ASC')->get();
        }
    }
    public function traerSMMR($id)
    {
        $empleado = z4_rel_ts_gp::all()->where('cz4_gp_id', $id)->where('cz4_ts_id', Auth()->user()->cz1_id_empleado)->first();
        if($empleado != null || Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST')){
        return z5_prueba_preguntas::with('smmr')
            ->where('cz5_gp_id', $id)
            ->where('cz5_categoria', 'smmr')
            ->get();
        }
    }
    public function updateRA(Request $request)
    {
        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') ) {
        $ra = z5_prueba_preguntas::find($request->cz5_id);
        $ra->cz5_pregunta = $request->cz5_pregunta;
        $ra->save();
        return $ra;
        }
    }
    public function delete($id)
    {
        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') ) {
        $pregunta = z5_prueba_preguntas::find($id);
        $pregunta->delete();
        }

    }
}
