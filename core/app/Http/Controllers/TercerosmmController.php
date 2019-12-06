<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Terceros_mm;

class TercerosmmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function show()
    {
        //return Auth::user()->cz1_ts_id;

        return Terceros_mm::select(
            "dbo.t015_mm_contactos.f015_contacto",
            "dbo.t015_mm_contactos.f015_direccion1",
            "dbo.t015_mm_contactos.f015_id_barrio",
            "dbo.t015_mm_contactos.f015_telefono",
            "dbo.t015_mm_contactos.f015_email",
            "dbo.t015_mm_contactos.f015_celular",
            "dbo.w0541_terceros_seleccion.c0541_id",
            "c0541_apellido2",
            "c0541_apellido1",
            "c0541_nombres"

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
            
        )->where('dbo.t200_mm_terceros.f200_rowid',  Auth()->user()->cz1_id_empleado ) 
                               
            ->get();

    }
}
