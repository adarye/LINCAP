<?php

namespace App\Http\Controllers;

use App\z4_rel_ts_gp;
use App\z11_resultados;
use App\Terceros_mm;
use App\Terceros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AsignacionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function guardar(Request $request)
    {
        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') ) {
        //return $request->seleccionados;
        $relacion = new z4_rel_ts_gp;
        $relacion->cz4_gp_id = $request->id_prueba;
        $relacion->cz4_ts_id = $request->id;
        $relacion->cz4_estado = 0;
        $relacion->save();

        return $relacion;
        }
    }
    public function delete(Request $request)
    {
        //return $request->seleccionados;
        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') ) {
        $prueba = z4_rel_ts_gp::where('cz4_ts_id', $request->id_ts)->where('cz4_gp_id', $request->id_prueba)->first();
        $prueba->delete();
        $respuestas = z11_resultados::where('cz11_id_empleado', $request->id_ts)->where('cz11_id_gp', $request->id_prueba)->delete();
        
        }
    }
    public function index($id)
    {
        if (Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') ) {
        $registros = z4_rel_ts_gp::select('cz4_ts_id', 'cz4_calificacion')->where('cz4_gp_id', $id)->get();
        $j = json_decode($registros, true);
        return $registros;
        }
    }
    public function guardarTodos(Request $request)
    {
        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') ) {
        $todos = (array) $request->activos;
        $i = 0;

        foreach ($todos as $req) {
            $a = $todos[$i];
            $all = z4_rel_ts_gp::where('cz4_ts_id', $a['c0550_rowid_tercero'])
                ->where('cz4_gp_id', $request->id_prueba)
                ->get();
            if (count($all) <= 0) {
                $relacion = new z4_rel_ts_gp;
                $relacion->cz4_gp_id = $request->id_prueba;
                $relacion->cz4_ts_id = $a['c0550_rowid_tercero'];
                $relacion->cz4_estado = 0;
                $relacion->save();
            }
            $i++;

        }
    }

    }
    public function quitarTodos(Request $request)
    {
        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') ) {
        $todos = (array) $request->activos;
        $i = 0;

        foreach ($todos as $req) {
            $a = $todos[$i];
            $all = z4_rel_ts_gp::where('cz4_ts_id', $a['c0550_rowid_tercero'])
                ->where('cz4_gp_id', $request->id_prueba)
                ->first();
            if ($all != null) {
                $all->delete();
                $respuestas = z11_resultados::where('cz11_id_gp', $request->id_prueba)->delete();
            }
            $i++;

        }
    }
    
    }
    public function finalizarPrueba($id){
        
        $prueba = z4_rel_ts_gp::where('cz4_ts_id', Auth()->user()->cz1_id_empleado)->where('cz4_gp_id',$id)->first();
        $prueba->cz4_estado = 2;
        $prueba->save();
    }

    public function contar($id){
        return z4_rel_ts_gp::where('cz4_gp_id',$id)->count();
    }
    public function conseguirEstado($id, $empleado){
        return  z4_rel_ts_gp::select('cz4_id', 'cz4_estado', 'cz4_calificacion')->where('cz4_ts_id', $empleado)
        ->where('cz4_gp_id', $id)->first();
    }
    public function conseguirNota($id){

       return Terceros_mm::select(
            "c0541_rowid",
            "c0541_nombres",
            "c0541_id",
            "c0541_apellido1",
            "c0541_apellido2",
            "c0540_fecha_nacimiento",
            "c0550_fecha_ingreso",
            "c0763_descripcion",
            "c0550_rowid_tercero",
            "c0550_fecha_contrato_hasta",
            "f285_descripcion",
            "f285_id",
            "f200_rowid"

        )->join(
            'dbo.t200_mm_terceros',
            'dbo.t015_mm_contactos.f015_rowid',
            '=',
            'dbo.t200_mm_terceros.f200_rowid_contacto'

        )->join(
            'dbo.w0540_empleados',
            'dbo.t200_mm_terceros.f200_rowid',
            '=',
            'dbo.w0540_empleados.c0540_rowid_tercero'

        )->join(
            'dbo.w0541_terceros_seleccion',
            'dbo.w0540_empleados.c0540_rowid_prospecto'
            ,
            '=',
            'dbo.w0541_terceros_seleccion.c0541_rowid'

        )->join(
            'dbo.w0550_contratos',
            'dbo.w0540_empleados.c0540_rowid_tercero',
            '=',
            'dbo.w0550_contratos.c0550_rowid_tercero'

        )->join(
            'dbo.w0763_gh01_cargos',
            'dbo.w0763_gh01_cargos.c0763_rowid',
            '=',
            'dbo.w0550_contratos.c0550_rowid_cargo'

        )->join(
            'dbo.t284_co_ccosto',
            'dbo.w0550_contratos.c0550_rowid_ccosto',
            '=',
            'dbo.t284_co_ccosto.f284_rowid'

        )->join(
            'dbo.t285_co_centro_op',
            'dbo.w0550_contratos.c0550_id_co',
            '=',
            'dbo.t285_co_centro_op.f285_id'

         )
            ->where('c0550_ind_estado', '1')
            // ->with('notas')
            ->orderBy('c0541_nombres','ASC')
            ->get();

        
    }
    
}
