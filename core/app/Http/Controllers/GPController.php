<?php

namespace App\Http\Controllers;

use App\z3_gestion_pruebas;
use Illuminate\Http\Request;

class GPController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function crear(Request $request)
    {

        $prueba = new z3_gestion_pruebas();
        $prueba->cz3_nombre = $request->datos['cz3_nombre'];
        $prueba->cz3_descripcion = $request->datos['cz3_descripcion'];
        $prueba->cz3_categoria = $request->categoria;
        $prueba->cz3_id_creador = Auth()->user()->cz1_id_empleado;
        $prueba->cz3_fecha_apertura = $request->datos['cz3_fecha_apertura'];
        $prueba->cz3_fecha_cierre = $request->datos['cz3_fecha_cierre'];
        $prueba->save();

        return $prueba;
    }

    public function index($categoria)
    {

        return z3_gestion_pruebas::select('cz3_id', 'cz3_nombre', 'cz3_categoria',
            'cz3_descripcion', 'cz3_id_creador', 'cz3_fecha_apertura','cz3_fecha_cierre')
            ->where('cz3_id_creador', Auth()->user()->cz1_id_empleado)
            ->where('cz3_categoria', $categoria)->get();
    }
    public function update(Request $request)
    {

        $prueba = z3_gestion_pruebas::find($request->cz3_id);
        $prueba->cz3_nombre = $request->cz3_nombre;
        $prueba->cz3_descripcion = $request->cz3_descripcion;
        // $prueba->cz3_fecha_apertura = $request->cz3_fecha_apertura;
        $prueba->cz3_fecha_cierre = $request->cz3_fecha_cierre;
        $prueba->save();

        return $prueba;
    }
    public function cerrar(Request $request)
    {
        $prueba = z3_gestion_pruebas::find($request->id);
        $prueba->cz3_fecha_cierre = $request->fecha_actual;
        $prueba->save();
        return $prueba;
    }
    public function delete($id)
    {
        $prueba = z3_gestion_pruebas::find($id);
        $prueba->delete();
    }
    public function buscar($id)
    {
        return z3_gestion_pruebas::find($id);
    }

    public function traerPendientes($id)
    {
        return z3_gestion_pruebas::select(
            'cz3_nombre',
            'cz3_descripcion',
            'cz3_fecha_apertura',
            'cz3_fecha_cierre',
            'f200_nombres',
            'f200_apellido1',
            'f200_apellido2',
            'cz3_id_creador',
            'cz3_id',
            'cz4_estado'
        )
            ->join(
                'dbo.z4_rel_ts_gps',
                'dbo.z3_gestion_pruebas.cz3_id',
                '=',
                'dbo.z4_rel_ts_gps.cz4_gp_id'
            )
            ->join(
                'dbo.t200_mm_terceros',
                'dbo.z3_gestion_pruebas.cz3_id_creador',
                '=',
                'dbo.t200_mm_terceros.f200_rowid'
            )->where('cz4_ts_id', Auth()->user()->cz1_id_empleado)
            ->where('cz3_categoria', $id)
            ->where('cz4_estado', '!=', 2)
            ->orderBy('cz3_fecha_apertura', 'desc')
            ->get();

    }
    public function traerCompletadas($id)
    {
        return z3_gestion_pruebas::select(
            'cz3_nombre',
            'cz3_descripcion',
            'cz3_fecha_apertura',
            'cz3_fecha_cierre',
            'f200_nombres',
            'f200_apellido1',
            'f200_apellido2',
            'cz3_id_creador',
            'cz3_id',
            'cz4_estado'
        )
            ->join(
                'dbo.z4_rel_ts_gps',
                'dbo.z3_gestion_pruebas.cz3_id',
                '=',
                'dbo.z4_rel_ts_gps.cz4_gp_id'
            )
            ->join(
                'dbo.t200_mm_terceros',
                'dbo.z3_gestion_pruebas.cz3_id_creador',
                '=',
                'dbo.t200_mm_terceros.f200_rowid'
            )->where('cz4_ts_id', Auth()->user()->cz1_id_empleado)
            ->where('cz3_categoria', $id)
            ->where('cz4_estado', 2)
            ->orderBy('cz3_fecha_apertura', 'desc')
            ->get();

    }

}
