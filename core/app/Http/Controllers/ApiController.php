<?php

namespace App\Http\Controllers;

use App\Terceros;
use App\t285_co_centro_op;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use App\w0706_gh01_tipos_vivienda;
use App\Terceros_mm;
// use Illuminate\Database\Eloquent\Collection;


class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function traerActivos(Request $request)
    {
        if (Gate::allows('isSST') || Gate::allows('isAdmin') || Gate::allows('isRRHH')) {
        if ($request->ajax()) {
           
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
                "f200_rowid",
                "f284_descripcion",
                "c0550_rowid_cargo",
                "c0550_fecha_retiro"
                
    
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
            ->with('empleado_info')
                ->where('c0550_ind_estado', '1')
                ->orderBy('c0541_nombres', 'ASC')
                ->get();

        } else {
            return view('pages.index');
        }
    }
    }
    //TRAE INF CORPORATIVA, CONTRATO Y EMPLEADO, SE PODRIA PONER EN EL BUSCAR GENERAL, PERO ME TRAERIA SOLO LOS EMPLEADOS QUE TIENEN ESTO ACTUALIZADO
    public function traerInfCorporativa(){
        if (Gate::denies('isDefault')) {
        return Terceros::select(
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
            "cz9_mail_corp",
            "cz9_tel_corp",
            "cz9_cel_corp"
            


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

        )->join(
            'dbo.z9_empleados_info',
            'dbo.w0540_empleados.c0540_rowid_tercero',
            '=',
            'dbo.z9_empleados_info.cz9_id_empleado'

         )
            ->where('c0550_ind_estado', '1')
            
            ->get();

    {
    }
}
           

    }
    
    public function traerRetirados(Request $request)
    {
        if (Gate::allows('isSST') || Gate::allows('isAdmin') || Gate::allows('isRRHH')) {
            $activos = Terceros_mm::select(
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
                "f200_rowid",
                "f284_descripcion",
                "c0550_rowid_cargo"
                
    
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
            ->with('empleado_info')
                ->where('c0550_ind_estado', '1')
                ->orderBy('c0541_nombres', 'ASC')
                ->get();

            //EMPLEADOS RETIRADOS
            $retirados= Terceros_mm::select(
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
                "f200_rowid",
                "f284_descripcion",
                "c0550_rowid_cargo"
                
    
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
            ->with('empleado_info')
                ->where('c0550_ind_estado', '2')  
                ->get();

                $resultados = $retirados->unique();
                $retirados2 = json_decode($resultados, true);
                
                
     
        return [$activos,
        $retirados2];
            }
        
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
        if (Gate::allows('isAdmin')) {
        return Terceros::select(
            'c0541_rowid',
            'dbo.w0540_empleados.c0540_rowid_tercero',
            'c0541_nombres',
            'c0541_apellido1',
            'c0541_apellido2'
            )
            ->join(
                'dbo.w0540_empleados',
                'dbo.w0541_terceros_seleccion.c0541_rowid',
                '=',
                'dbo.w0540_empleados.c0540_rowid_prospecto'


            )
            ->where('dbo.w0541_terceros_seleccion.c0541_id', '=', $id)
            ->first();    
    }   
    }

    public function myAvatar(Request $request)
{
    // Verificamos si hay un file con nombre avatar
    if ($request->hasFile('avatar')) {
        // Si es así , almacenamos en la carpeta public/avatars
        // esta estará dentro de public/defaults/
       $url = $request->avatar->store('users/avatar');
        $userAvatarUpdate = User::find(auth()->id());
        /** Áctualización y 
         return JSON*/
    }
    return "Noo Llego una imagen";
}

    public function getCo(){
        return t285_co_centro_op::all();
    }
    public function getViviendas(){
        return w0706_gh01_tipos_vivienda::all();

    }

}
