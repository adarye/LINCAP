<?php

namespace App\Http\Controllers;

use App\z11_resultados;
use Illuminate\Http\Request;
use App\z4_rel_ts_gp;
use Illuminate\Support\Facades\Gate;
use App\z3_gestion_pruebas;
use Carbon\Carbon;

class RespuestasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function guardarSMUR(Request $request)
    {

        $estado = z4_rel_ts_gp::select('cz4_id')->where('cz4_ts_id', Auth()->user()->cz1_id_empleado)
        ->where('cz4_gp_id', $request->id_gp)->first();
        $estado->cz4_estado = '1';
        $estado->save();

    //     $fecha = Carbon::createFromFormat('d/m/Y', '11/06/2020');
    //     $date = Carbon::now();
    //     $date = $date->format('d-m-Y');

    //    if ($fecha->greaterThan($date)){
    //          return 'hola';
    //      }
    //       return $fecha.'  '. $date;

        $register = z11_resultados::select('cz11_id')->where('cz11_id_empleado', Auth()->user()->cz1_id_empleado)
        ->where('cz11_pp_id', $request->id_pp)->delete();

        $resultado = new z11_resultados;
        $resultado->cz11_id_gp = $request->id_gp;
        $resultado->cz11_id_empleado = Auth()->user()->cz1_id_empleado;
        $resultado->cz11_pp_id = $request->id_pp;
        $resultado->cz11_categoria = $request->categoria;
        $resultado->cz11_rta = $request->id_rta;
        $resultado->cz11_rta_ra = $request->rta_ra;
        $resultado->save();
        return $resultado;
    }

    public function guardarSMMR(Request $request)
    {
        $estado = z4_rel_ts_gp::select('cz4_id')->where('cz4_ts_id', Auth()->user()->cz1_id_empleado)
        ->where('cz4_gp_id', $request->id_gp)->first();
        $estado->cz4_estado = '1';
        $estado->save();

         $register = z11_resultados::select('cz11_id')->where('cz11_id_empleado', Auth()->user()->cz1_id_empleado)
         ->where('cz11_pp_id', $request->id_pp)
         ->where('cz11_rta', $request->id_rta)
         ->delete();

        //  return $register;
          
         if($register == 0){
        $resultado = new z11_resultados;
        $resultado->cz11_id_gp = $request->id_gp;
        $resultado->cz11_id_empleado = Auth()->user()->cz1_id_empleado;
        $resultado->cz11_pp_id = $request->id_pp;
        $resultado->cz11_categoria = $request->categoria;
        $resultado->cz11_rta = $request->id_rta;
        $resultado->cz11_rta_ra = $request->rta_ra;
        $resultado->save();
        return $resultado;
         }
    }
    public function guardarRA(Request $request)
    {
        $estado = z4_rel_ts_gp::select('cz4_id')->where('cz4_ts_id', Auth()->user()->cz1_id_empleado)
        ->where('cz4_gp_id', $request->id_gp)->first();
        $estado->cz4_estado = '1';
        $estado->save();

         $register = z11_resultados::select('cz11_id')->where('cz11_id_empleado', Auth()->user()->cz1_id_empleado)
         ->where('cz11_pp_id', $request->id_pp)->first();
         

        //  return $register;
          
         if($register == null){
        $resultado = new z11_resultados;
        $resultado->cz11_id_gp = $request->id_gp;
        $resultado->cz11_id_empleado = Auth()->user()->cz1_id_empleado;
        $resultado->cz11_pp_id = $request->id_pp;
        $resultado->cz11_categoria = $request->categoria;
        $resultado->cz11_rta = $request->id_rta;
        $resultado->cz11_rta_ra = $request->rta_ra;
        $resultado->save();
        return $resultado;
          }
          else{
            $register->cz11_id_gp = $request->id_gp;
            $register->cz11_id_empleado = Auth()->user()->cz1_id_empleado;
            $register->cz11_pp_id = $request->id_pp;
            $register->cz11_categoria = $request->categoria;
            $register->cz11_rta = $request->id_rta;
            $register->cz11_rta_ra = $request->rta_ra;
            $register->save(); 
          }
    }

    public function traerRespuestasSMUR($id, $empleado)
    {
         $prueba = z3_gestion_pruebas::find($id);
        //  return $prueba->cz3;
         if( Gate::allows('isAdmin') || 
         Gate::allows('isRRHH') || Gate::allows('isSST')   || $empleado == Auth()->user()->cz1_id_empleado){
              if($prueba->cz3_id_creador == Auth()->user()->cz1_id_empleado || $empleado == Auth()->user()->cz1_id_empleado){    
        return z11_resultados::select('cz11_rta')->where('cz11_id_gp', $id)
        ->where('cz11_id_empleado', $empleado)->where('cz11_categoria', 'smur')->get();
              }
    }
    }
    public function traerRespuestasSMMR($id, $empleado)
    {
        $prueba = z3_gestion_pruebas::find($id);
        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') || $empleado == Auth()->user()->cz1_id_empleado) {
            if($prueba->cz3_id_creador == Auth()->user()->cz1_id_empleado || $empleado == Auth()->user()->cz1_id_empleado){
            return z11_resultados::select('cz11_rta')->where('cz11_id_gp', $id)
            ->where('cz11_id_empleado', $empleado)->where('cz11_categoria', 'smmr')->get();
            }
        }
    }
    public function traerRespuestasRA($id, $empleado)
    {
        $prueba = z3_gestion_pruebas::find($id);

        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') || $empleado == Auth()->user()->cz1_id_empleado) {
            if($prueba->cz3_id_creador == Auth()->user()->cz1_id_empleado || $empleado == Auth()->user()->cz1_id_empleado){ 
        return z11_resultados::select('cz11_rta_ra', 'cz11_pp_id')->where('cz11_id_gp', $id)
            ->where('cz11_id_empleado', $empleado)->where('cz11_categoria', 'ra')->get();
            } 
        }
    }

}
