<?php

namespace App\Http\Controllers;

use App\Terceros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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

    public function show()
    {
        //return Auth::user()->cz1_ts_id;

        return Terceros::select(
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
            
        )->where('dbo.t200_mm_terceros.f200_rowid', 1047//Auth::user()->cz1_ts_id) 
            )                    
            ->get();

    }
    public function update(Request $request, $id)
    {
        $empleado = Terceros::find($id);
        $empleado->c0541_correo = $request->email;
        $empleado->c0541_telefono_1 = $request->telefono;
        $empleado->c0541_direccion_1 = $request->direccion;
        $empleado->c0541_barrio = $request->barrio;
        $empleado->c0541_ciudad_contacto = $request->ciudad;
        $empleado->save();
        return $empleado;
    }

    public function buscarTercero($id)
    {

        return Terceros::select('c0541_rowid')->where('c0541_id', '=', $id)->first();
    }

}
