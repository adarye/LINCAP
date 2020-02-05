<?php

namespace App\Http\Controllers;

use App\z3_gestion_pruebas;
use App\z4_rel_ts_gp;
use App\z5_prueba_preguntas;
use App\z11_resultados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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

        if ($register == 0) {
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

        if ($register == null) {
            $resultado = new z11_resultados;
            $resultado->cz11_id_gp = $request->id_gp;
            $resultado->cz11_id_empleado = Auth()->user()->cz1_id_empleado;
            $resultado->cz11_pp_id = $request->id_pp;
            $resultado->cz11_categoria = $request->categoria;
            $resultado->cz11_rta = $request->id_rta;
            $resultado->cz11_rta_ra = $request->rta_ra;
            $resultado->cz11_nota = 0;
            $resultado->save();
            return $resultado;
        } else {
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
        if (Gate::allows('isAdmin') ||
            Gate::allows('isRRHH') || Gate::allows('isSST') || $empleado == Auth()->user()->cz1_id_empleado) {
            if ($prueba->cz3_id_creador == Auth()->user()->cz1_id_empleado || $empleado == Auth()->user()->cz1_id_empleado) {
                return z11_resultados::select('cz11_rta', 'cz11_nota')->where('cz11_id_gp', $id)
                    ->where('cz11_id_empleado', $empleado)->where('cz11_categoria', 'smur')->get();
            }
        }
    }
    public function traerRespuestasSMMR($id, $empleado)
    {
        $prueba = z3_gestion_pruebas::find($id);
        if (Gate::allows('isAdmin') ||
            Gate::allows('isRRHH') || Gate::allows('isSST') || $empleado == Auth()->user()->cz1_id_empleado) {
            if ($prueba->cz3_id_creador == Auth()->user()->cz1_id_empleado || $empleado == Auth()->user()->cz1_id_empleado) {
                return z11_resultados::select('cz11_rta', 'cz11_nota')->where('cz11_id_gp', $id)
                    ->where('cz11_id_empleado', $empleado)->where('cz11_categoria', 'smmr')->get();
            }
        }
    }
    public function traerRespuestasRA($id, $empleado)
    {
        $prueba = z3_gestion_pruebas::find($id);

        if (Gate::allows('isAdmin') ||
            Gate::allows('isRRHH') || Gate::allows('isSST') || $empleado == Auth()->user()->cz1_id_empleado) {
            if ($prueba->cz3_id_creador == Auth()->user()->cz1_id_empleado || $empleado == Auth()->user()->cz1_id_empleado) {
                return z11_resultados::select('cz11_rta_ra', 'cz11_pp_id', 'cz11_nota')->where('cz11_id_gp', $id)
                    ->where('cz11_id_empleado', $empleado)->where('cz11_categoria', 'ra')->get();
            }
        }
    }
    public function calificar($emp, $id)
    {
        $smur = z11_resultados::select(
            'cz11_id',
            'cz11_pp_id',
            'cz11_categoria',
            'cz11_rta_ra',
            'cz11_rta',
            'cz7_rta_correcta',
            'cz5_pregunta'
            // 'cz7_id'
        )->join(
            'z5_prueba_preguntas',
            'z11_resultados.cz11_pp_id',
            '=',
            'z5_prueba_preguntas.cz5_id'
        )
            ->join(
                'z7_rta_smurs',
                'z5_prueba_preguntas.cz5_id',
                '=',
                'z7_rta_smurs.cz7_pp_id'

            )
            ->where('cz11_id_gp', $id)
            ->where('cz11_id_empleado', $emp)
            ->distinct()
            ->get();
//RESPUESTAS CON MULTIPLE RESPUESTA

        $smmr = z11_resultados::select(
            'cz11_id',
            'cz11_pp_id',
            'cz11_categoria',
            'cz11_rta',
            'cz8_rta_correcta',
            'cz5_pregunta',
            'cz8_id'
        )->join(
            'z5_prueba_preguntas',
            'z11_resultados.cz11_pp_id',
            '=',
            'z5_prueba_preguntas.cz5_id'
        )
            ->join(
                'z8_rta_smmrs',
                'z5_prueba_preguntas.cz5_id',
                '=',
                'z8_rta_smmrs.cz8_pp_id'

            )
            ->where('cz11_id_gp', $id)
            ->where('cz11_id_empleado', $emp)
            ->orderBy('cz11_rta')
            ->get();

        //TOTAL DE PREGUNTAS ENCUESTAS
        $total_preguntas = z3_gestion_pruebas::join(
            'z5_prueba_preguntas',
            'z3_gestion_pruebas.cz3_id',
            '=',
            'z5_prueba_preguntas.cz5_gp_id'

        )->where('cz5_gp_id', $id)->count();

        //SACAR NOTA SMUR
        $acumulado = 0;
        $numero = 0;
        $pp = null;

        foreach ($smur as &$item) {

            if ($item->cz7_rta_correcta == $item->cz11_rta) {
                $numero = 5 / $total_preguntas;
                $acumulado = $acumulado + $numero;
            }

            $nota = z11_resultados::find($item->cz11_id);
            $nota->cz11_nota = $numero;
            $nota->save();

            $numero = 0;
        }

        //SACAR NOTA SMMR
        $total_preguntas_smmr = 0;
        $calificacion = 0;
        $rta_id = null;

        //   return $smmr;
        foreach ($smmr as &$item) {

            $total_preguntas_smmr = z5_prueba_preguntas::join(
                'z8_rta_smmrs',
                'z5_prueba_preguntas.cz5_id',
                '=',
                'z8_rta_smmrs.cz8_pp_id'

            )->where('cz8_pp_id', $item->cz11_pp_id)->where('cz8_rta_correcta', '!=', null)->count();

            if ($item->cz8_rta_correcta == $item->cz11_rta) {

                $valor = 5 / $total_preguntas;
                $puntaje = $valor / $total_preguntas_smmr;
                $calificacion = $calificacion + $puntaje;
                $acumulado = $acumulado + $calificacion;

                $nota = z11_resultados::find($item->cz11_id);
                $nota->cz11_nota = $calificacion;
                $nota->save();
                $calificacion = 0;

                $rta_id = $item->cz11_rta;

            } else {
                if ($rta_id != $item->cz11_rta) {
                    $nota = z11_resultados::find($item->cz11_id);
                    $nota->cz11_nota = $calificacion;
                    $nota->save();
                    $calificacion = 0;
                }
            }

        }

        $nota_final = z4_rel_ts_gp::where('cz4_ts_id', $emp)->where('cz4_gp_id', $id)->first();
        $nota_final->cz4_calificacion = $acumulado;
        $nota_final->save();
        return $acumulado;

    }
    public function validarInicio($id_prueba)
    {
        return z11_resultados::select('cz11_id')->where('cz11_id_gp', $id_prueba)->first();
    }

    public function calificaRA(Request $request)
    {
        $total_preguntas = z3_gestion_pruebas::join(
            'z5_prueba_preguntas',
            'z3_gestion_pruebas.cz3_id',
            '=',
            'z5_prueba_preguntas.cz5_gp_id'

        )->where('cz5_gp_id', $request->prueba)->count();

        $numero = 5 / $total_preguntas;

        if ($request->cal == 2  || $request->cal == 3) {
            if ($request->cal == 2){
            $numero = $numero / 2;
            }
            else{
                $numero = $numero / 1;
            }
            $nota = z11_resultados::where('cz11_pp_id', $request->pregunta)->where('cz11_id_empleado', $request->empleado)->first();
            $nota_anterior = $nota->cz11_nota;
            $nota->cz11_nota = $numero;
            $nota->save();

            $nota_final = z4_rel_ts_gp::where('cz4_ts_id', $request->empleado)->where('cz4_gp_id', $request->prueba)->first();
            $nota_final->cz4_calificacion = ($nota_final->cz4_calificacion - $nota_anterior) + $numero;
            $nota_final->save();

        } else if ($request->cal == 1) {
            $numero = $numero / 1;
            $nota = z11_resultados::where('cz11_pp_id', $request->pregunta)->where('cz11_id_empleado', $request->empleado)->first();
            $nota_anterior = $nota->cz11_nota;
            $nota->cz11_nota = 0;
            $nota->save();

            $nota_final = z4_rel_ts_gp::where('cz4_ts_id', $request->empleado)->where('cz4_gp_id', $request->prueba)->first();
            $nota_final->cz4_calificacion = ($nota_final->cz4_calificacion - $nota_anterior);
            $nota_final->save();
        }

        

       
        return $nota_final;

    }

}
