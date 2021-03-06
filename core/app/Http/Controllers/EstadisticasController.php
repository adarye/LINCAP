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
    public function __construct()
    {
        $this->middleware('auth');
    }
    protected $cargos;
    public  function buscarSMUR(Request $request){
       $empleado =  z3_gestion_pruebas::select('cz3_id_creador')->where('cz3_id',$request->id_prueba )->first();
    //    return $empleado;
       if(Gate::allows('isAdmin') || 
       Gate::allows('isRRHH')  || $empleado->cz3_id_creador == Auth()->user()->cz1_id_empleado){
          if($request->co != "SEDES" && $request->cargos ==[]  ) {
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
        }
        else if($request->co != "SEDES" && $request->cargos !=[]) {
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
             ->whereIn('c0763_rowid', $request->cargos)
             ->where('cz11_categoria', 'smur')->count();
        }
        else if($request->co == "SEDES" && $request->cargos ==[] ){
            
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
        else if($request->co == "SEDES" && $request->cargos !=[]){
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
             ->whereIn('c0763_rowid', $request->cargos)
             ->where('cz11_categoria', 'smur')->count();
        }
        }
    }
    
     //  return   z11_resultados::where('cz11_rta', $id)->where('cz11_categoria', 'smur')->count();

    
    public  function buscarSMMR(Request $request){
        // return z11_resultados::where('cz11_rta', $request->id)->where('cz11_categoria', 'smmr')->count();
        $empleado =  z3_gestion_pruebas::select('cz3_id_creador')->where('cz3_id',$request->id_prueba )->first();
        if(Gate::allows('isAdmin') || 
       Gate::allows('isRRHH') || $empleado->cz3_id_creador == Auth()->user()->cz1_id_empleado){
        if($request->co != "SEDES" && $request->cargos ==[]) {
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
             ->where('cz11_categoria', 'smmr')->count();
        }
        else if($request->co != "SEDES" && $request->cargos !=[]) {
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
             ->whereIn('c0763_rowid', $request->cargos)
             ->where('cz11_categoria', 'smmr')->count();
        }
        else if($request->co == "SEDES" && $request->cargos ==[]){
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
             
             ->where('cz11_categoria', 'smmr')->count();
        }
        else if($request->co == "SEDES" && $request->cargos !=[]){
           
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
             ->whereIn('c0763_rowid', $request->cargos)
             ->where('cz11_categoria', 'smmr')->count();
        }
       }

    }
    public function cargarCargos(){
        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') || Gate::allows('isJefe') ) {
        $this->cargos = w0763_gh01_cargos::select('c0763_rowid','c0763_descripcion')->orderBy('c0763_descripcion', 'ASC')->get();
        return $this->cargos;
        }
    }
    public function Resultados($id){
        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') || Gate::allows('isJefe') ) {
        $totalEmp = Terceros::join(
            'dbo.w0540_empleados',
            'dbo.w0541_terceros_seleccion.c0541_rowid',
            '=',
            'dbo.w0540_empleados.c0540_rowid_prospecto'

        )->join(
            'dbo.z4_rel_ts_gps',
            'dbo.w0540_empleados.c0540_rowid_tercero',
            '=',
            'dbo.z4_rel_ts_gps.cz4_ts_id'

         )->join(
            'dbo.w0550_contratos',
            'dbo.w0540_empleados.c0540_rowid_tercero',
            '=',
            'dbo.w0550_contratos.c0550_rowid_tercero'

        )
         ->where('c0550_ind_estado', '1')
         ->where('cz4_gp_id', $id)->count();
    
    
    
        $totalEvCont   = Terceros::join(
            'dbo.w0540_empleados',
            'dbo.w0541_terceros_seleccion.c0541_rowid',
            '=',
            'dbo.w0540_empleados.c0540_rowid_prospecto'

        )->join(
            'dbo.z4_rel_ts_gps',
            'dbo.w0540_empleados.c0540_rowid_tercero',
            '=',
            'dbo.z4_rel_ts_gps.cz4_ts_id'

         )->join(
            'dbo.w0550_contratos',
            'dbo.w0540_empleados.c0540_rowid_tercero',
            '=',
            'dbo.w0550_contratos.c0550_rowid_tercero'

        )
         ->where('c0550_ind_estado', '1')
         ->whereIn('cz4_estado', ['2','1'])
         ->where('cz4_gp_id', $id)->count();
    
        $totalEvPerd = Terceros::join(
            'dbo.w0540_empleados',
            'dbo.w0541_terceros_seleccion.c0541_rowid',
            '=',
            'dbo.w0540_empleados.c0540_rowid_prospecto'

        )->join(
            'dbo.z4_rel_ts_gps',
            'dbo.w0540_empleados.c0540_rowid_tercero',
            '=',
            'dbo.z4_rel_ts_gps.cz4_ts_id'

         )->join(
            'dbo.w0550_contratos',
            'dbo.w0540_empleados.c0540_rowid_tercero',
            '=',
            'dbo.w0550_contratos.c0550_rowid_tercero'

        )
         ->where('c0550_ind_estado', '1')
         ->whereIn('cz4_estado', ['2','1'])
         ->where('cz4_calificacion', '<' , 3.5)
         ->where('cz4_gp_id', $id)->count();

         $totalEvGan = Terceros::join(
            'dbo.w0540_empleados',
            'dbo.w0541_terceros_seleccion.c0541_rowid',
            '=',
            'dbo.w0540_empleados.c0540_rowid_prospecto'

        )->join(
            'dbo.z4_rel_ts_gps',
            'dbo.w0540_empleados.c0540_rowid_tercero',
            '=',
            'dbo.z4_rel_ts_gps.cz4_ts_id'

         )->join(
            'dbo.w0550_contratos',
            'dbo.w0540_empleados.c0540_rowid_tercero',
            '=',
            'dbo.w0550_contratos.c0550_rowid_tercero'

        )
         ->where('c0550_ind_estado', '1')
         ->whereIn('cz4_estado', ['2','1'])
         ->where('cz4_calificacion', '>=' , 3.5)
         ->where('cz4_gp_id', $id)->count();

         $promedio = Terceros::join(
            'dbo.w0540_empleados',
            'dbo.w0541_terceros_seleccion.c0541_rowid',
            '=',
            'dbo.w0540_empleados.c0540_rowid_prospecto'

        )->join(
            'dbo.z4_rel_ts_gps',
            'dbo.w0540_empleados.c0540_rowid_tercero',
            '=',
            'dbo.z4_rel_ts_gps.cz4_ts_id'

         )->join(
            'dbo.w0550_contratos',
            'dbo.w0540_empleados.c0540_rowid_tercero',
            '=',
            'dbo.w0550_contratos.c0550_rowid_tercero'

        )
         ->where('c0550_ind_estado', '1')
         ->whereIn('cz4_estado', ['2','1'])
         ->where('cz4_gp_id', $id)->avg('cz4_calificacion');

         return [ $totalEmp,$totalEvCont, $totalEvPerd, $totalEvGan, $promedio ];
        }
    }
    

    }
    

