<?php

namespace App\Http\Controllers;

use App\z3_gestion_pruebas;
use App\z4_rel_ts_gp;
use App\z5_prueba_preguntas;
use App\z11_resultados;
use App\Terceros;
use App\w0763_gh01_cargos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EstadisticasController extends Controller
{
    public  function buscarSMUR(Request $request){
       
          if($request->co != "SEDES") {
            return Terceros::join(
                'dbo.w0540_empleados',
                'dbo.w0541_terceros_seleccion.c0541_rowid',
                '=',
                'dbo.w0540_empleados.c0540_rowid_prospecto'
    
            )->join(
                'dbo.z11_resultados',
                'dbo.w0540_empleados.c0540_rowid_tercero',
                '=',
                'dbo.z11_resultados.cz11_id_empleado'
               
           
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
    
             )->where('c0550_ind_estado', '1')
             ->where('cz11_rta', $request->id)
             ->where('t285_co_centro_op.f285_id', $request->co)
             ->where('cz11_categoria', 'smur')->count();
        }else{
            return Terceros::join(
                'dbo.w0540_empleados',
                'dbo.w0541_terceros_seleccion.c0541_rowid',
                '=',
                'dbo.w0540_empleados.c0540_rowid_prospecto'
    
            )->join(
                'dbo.z11_resultados',
                'dbo.w0540_empleados.c0540_rowid_tercero',
                '=',
                'dbo.z11_resultados.cz11_id_empleado'
               
           
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
    
             )->where('c0550_ind_estado', '1')
             ->where('cz11_rta', $request->id)
             ->where('cz11_categoria', 'smur')->count();
        }
        

        //  return   z11_resultados::where('cz11_rta', $id)->where('cz11_categoria', 'smur')->count();

    }
    public  function buscarSMMR($id){
        return z11_resultados::where('cz11_rta', $id)->where('cz11_categoria', 'smmr')->count();

    }
    public function cargarCargos(){
        return w0763_gh01_cargos::all();
    }
}
