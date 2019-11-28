<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Terceros;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Terceros::select(
                "c0541_rowid",
                "c0541_nombres",
                "c0541_id",
                "c0541_apellido1",
                "c0541_apellido2",
                "c0540_fecha_nacimiento",
                "c0550_fecha_ingreso",
                "c0763_descripcion",
                "c0550_rowid_tercero"

            )->join(
                'dbo.w0540_empleados',
                'dbo.w0541_terceros_seleccion.c0541_rowid',
                '=',
                'dbo.w0540_empleados.c0540_rowid_prospecto'

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

            )
            ->where('c0550_ind_estado', '1')
            ->get();
            
        } else {
            return view('pages.index');
        }
    }

    public function show($id){
        return Terceros::select(
            "c0541_rowid",
            "c0541_nombres",
            "c0541_id",
            "c0541_apellido1",
            "c0541_apellido2",
            "c0540_fecha_nacimiento",
            "c0550_fecha_ingreso",
            "c0763_descripcion"

        )->join(

            'dbo.w0540_empleados',
            'dbo.w0541_terceros_seleccion.c0541_rowid',
            '=',
            'dbo.w0540_empleados.c0540_rowid_prospecto'



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

        )->where(
            'c0541_id',
            $id

        )->get();
        
    }
    public function buscarTercero($id){

        return Terceros::select('c0541_rowid')->where('c0541_id', '=', $id)->first();
    }

}
