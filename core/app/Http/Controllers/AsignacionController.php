<?php

namespace App\Http\Controllers;

use App\z4_rel_ts_gp;
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
            // return $all;
            if ($all != null) {
                // $all = z4_rel_ts_gp::find($all[0]->cz4_id);
                $all->delete();
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
}
