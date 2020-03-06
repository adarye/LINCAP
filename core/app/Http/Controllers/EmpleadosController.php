<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleados;
use Jenssegers\Date\Date;

class EmpleadosController extends Controller
{
    //
    public function imprimir(){

        $empleado = Empleados::select(
        "c0541_nombres",
        "c0541_id",
        "c0541_apellido1",
        "c0541_apellido2",
        "c0550_salario",
        "c0763_descripcion",
        "f013_descripcion",
        "c0550_fecha_ingreso",
        "c0550_fecha_contrato_hasta"

        )->join(
        'dbo.w0541_terceros_seleccion',
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

        )->join(
        'dbo.t013_mm_ciudades',
        'dbo.t013_mm_ciudades.f013_id',
        '=',
        'dbo.w0540_empleados.c0540_id_ciudad_exp_identif'

        )
        ->where('c0540_rowid_tercero', Auth()->user()->cz1_id_empleado)
        ->where('c0550_ind_estado', '1')
        ->first();

        $date = Date::now()->format('l j F Y');
        
        $view = view('certificaciones.certificado_laboral', compact('empleado', 'date'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        // return PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
        // ->loadView($view)->stream();

         return $pdf->setOptions([ 'isRemoteEnabled' => true])->stream();
        // return $pdf->stream('invoice');
    }
}
