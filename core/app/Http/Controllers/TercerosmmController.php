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
            "dbo.t015_mm_contactos.f015_id_pais",
            "dbo.t015_mm_contactos.f015_id_depto",
            "dbo.t015_mm_contactos.f015_id_ciudad",
            "dbo.t015_mm_contactos.f015_id_barrio",
            "c0541_apellido2",
            "c0541_apellido1",
            "c0541_nombres",
            'dbo.w0540_empleados.c0540_rowid_tercero'

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
    public function update(Request $request, $id){ 
         Terceros_mm::select('f015_rowid')
       ->join(
       't200_mm_terceros', 
       't015_mm_contactos.f015_rowid', 
       '=',
       't200_mm_terceros.f200_rowid_contacto')
       ->where('t200_mm_terceros.f200_rowid', $id)
       ->update(['t015_mm_contactos.f015_email' => $request->email,
                't015_mm_contactos.f015_telefono' => $request->telefono,
                't015_mm_contactos.f015_celular' => $request->celular,
                't015_mm_contactos.f015_direccion1' => $request->direccion,
                't015_mm_contactos.f015_id_ciudad' => $request->ciudad,
                't015_mm_contactos.f015_id_barrio' => $request->barrio
                
       ]);

      Terceros_mm::select('f015_rowid')
       ->join(
        't201_mm_clientes',
        't015_mm_contactos.f015_rowid',
        '=',
        't201_mm_clientes.f201_rowid_contacto'
       )
       ->where('t201_mm_clientes.f201_rowid_tercero', $id)
       ->update(['t015_mm_contactos.f015_email' => $request->email,
                't015_mm_contactos.f015_telefono' => $request->telefono,
                't015_mm_contactos.f015_celular' => $request->celular,
                't015_mm_contactos.f015_direccion1' => 'TRABAJADOR LINCO',
                't015_mm_contactos.f015_id_ciudad' => $request->ciudad,
                't015_mm_contactos.f015_id_barrio' => $request->barrio
       ]);

       Terceros_mm::select('f015_rowid')
       ->join(
        't202_mm_proveedores',
        't015_mm_contactos.f015_rowid',
        '=',
        't202_mm_proveedores.f202_rowid_contacto'
       )
       ->where('t202_mm_proveedores.f202_rowid_tercero', $id)
       ->update(['t015_mm_contactos.f015_email' => $request->email,
                't015_mm_contactos.f015_telefono' => $request->telefono,
                't015_mm_contactos.f015_celular' => $request->celular,
                't015_mm_contactos.f015_direccion1' => $request->direccion,
                't015_mm_contactos.f015_id_ciudad' => $request->ciudad,
                't015_mm_contactos.f015_id_barrio' => $request->barrio
       ]);
    }

    public function traerEmpleados(){
        return Terceros_mm::select(
            "dbo.t015_mm_contactos.f015_contacto",
            "dbo.t015_mm_contactos.f015_direccion1",
            "dbo.t015_mm_contactos.f015_id_barrio",
            "dbo.t015_mm_contactos.f015_telefono",
            "dbo.t015_mm_contactos.f015_email",
            "dbo.t015_mm_contactos.f015_celular",
            "dbo.t015_mm_contactos.f015_id_pais",
            "dbo.t015_mm_contactos.f015_id_depto",
            "dbo.t015_mm_contactos.f015_id_ciudad",
            "dbo.t015_mm_contactos.f015_id_barrio",
            "f200_apellido2",
            "f200_apellido1",
            "f200_nombres",
            'dbo.w0540_empleados.c0540_rowid_tercero',
            "c0540_fecha_exp_identif",
            "c0540_ind_sexo",
            "c0540_fecha_nacimiento",
            "c0763_descripcion",
            "c0550_fecha_ingreso",
            "c0550_fecha_contrato_hasta",
            "c0550_rowid_centros_trabajo",
            "c0515_id",
            "c0516_id",
            "c0517_id",
            "f284_descripcion",
            "c0504_descripcion",
            "f011_descripcion",
            "f012_descripcion",
            "f013_descripcion",
            'f200_id',
            'c0550_rowid'

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
            'dbo.w0515_entidades_eps',
            'dbo.w0550_contratos.c0550_rowid_entidad_eps',
            '=',
            'dbo.w0515_entidades_eps.c0515_rowid'

        )->join(
            'dbo.w0516_entidades_afp',
            'dbo.w0550_contratos.c0550_rowid_entidad_pension',
            '=',
            'dbo.w0516_entidades_afp.c0516_rowid'

        )->join(
            'dbo.w0517_entidades_arp',
            'dbo.w0550_contratos.c0550_rowid_entidad_arp',
            '=',
            'dbo.w0517_entidades_arp.c0517_rowid'

        )->join(
            'dbo.t284_co_ccosto',
            'dbo.w0550_contratos.c0550_rowid_ccosto',
            '=',
            'dbo.t284_co_ccosto.f284_rowid'

        )->join(
            'dbo.w0504_tipos_nomina',
            'dbo.w0550_contratos.c0550_rowid_tipo_nomina',
            '=',
            'dbo.w0504_tipos_nomina.c0504_rowid'
        )->join(
            'dbo.t011_mm_paises',
            'dbo.w0540_empleados.c0540_id_pais_exp_identif',
            '=',
            'dbo.t011_mm_paises.f011_id'

        )->join(
            'dbo.t012_mm_deptos',
            'dbo.w0540_empleados.c0540_id_depto_exp_identif',
            '=',
            'dbo.t012_mm_deptos.f012_id'

        )->join(
            'dbo.t013_mm_ciudades',
            'dbo.w0540_empleados.c0540_id_ciudad_exp_identif',
            '=',
            'dbo.t013_mm_ciudades.f013_id'

        )
        
            ->where('c0550_ind_estado', '1')
            ->where('f200_rowid', Auth()->user()->cz1_id_empleado)  
            //->distinct("c0515_id")           
            ->first();
    }
}
