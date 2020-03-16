<?php

namespace App\Http\Controllers;

use App\Contrato;
use App\Empleados;
use App\Terceros_mm;
use App\z9_empleados_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TercerosmmController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request, $id)
    {

        //TRAE DATOS DE CLIENTES PROVEEDORES Y TERCEROS
        if ($id == Auth()->user()->cz1_id_empleado || Gate::allows('isAdmin') ||
            Gate::allows('isRRHH') || Gate::allows('isSST')) {

            $id_depto = Empleados::select("c0540_id_depto_nacimiento", "c0540_id_pais_nacimiento")
                ->where("c0540_rowid_tercero", $id)->first();

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
                "c0540_fecha_nacimiento",
                'dbo.w0540_empleados.c0540_ind_sexo',
                'dbo.w0540_empleados.c0540_rowid_tercero',
                'c0540_id_nivel_educativo',
                'c0702_descripcion',
                'f011_descripcion',
                'f012_descripcion',
                'f013_descripcion',
                'c0702_descripcion',
                'c0540_ind_estado_civil',
                'c0541_rowid_clases_sociales',
                'c0541_ind_grupo_sanguineo'
                
                // ,'c0706_descripcion'

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
                'dbo.w0702_gh01_nivel_academico',
                'dbo.w0540_empleados.c0540_rowid_nivel_educativo'
                ,
                '=',
                'dbo.w0702_gh01_nivel_academico.c0702_rowid'

            )->join(
                'dbo.t011_mm_paises',
                'dbo.w0540_empleados.c0540_id_pais_nacimiento',
                '=',
                'dbo.t011_mm_paises.f011_id'

            )->join(
                'dbo.t012_mm_deptos',
                'dbo.w0540_empleados.c0540_id_depto_nacimiento',
                '=',
                'dbo.t012_mm_deptos.f012_id'
            )->join(
                'dbo.w0541_terceros_seleccion',
                'dbo.w0540_empleados.c0540_rowid_prospecto'
                ,
                '=',
                'dbo.w0541_terceros_seleccion.c0541_rowid'
            )->join(
                'dbo.t013_mm_ciudades',
                'dbo.w0540_empleados.c0540_id_ciudad_nacimiento',
                '=',
                'dbo.t013_mm_ciudades.f013_id'
            )
                ->where('dbo.t200_mm_terceros.f200_rowid', $id)
                ->where('f013_id_depto', $id_depto->c0540_id_depto_nacimiento)
                ->where('f012_id_pais', $id_depto->c0540_id_pais_nacimiento)

                ->get();
        }else{
            return redirect('/accces-denied');   
        }  

    }

    //EN UPDATE SE ACTUALIZARA LOS DATOS DE TODAS LAS TABLAS QUE ANTES HICIMOS BUSQUEDAS
    public function update(Request $request, $id)
    {
         return $request;
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
                't015_mm_contactos.f015_id_barrio' => $request->barrio,

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
                't015_mm_contactos.f015_id_barrio' => $request->barrio,
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
                't015_mm_contactos.f015_id_barrio' => $request->barrio,
            ]);

        $estado = z9_empleados_info::all()->where('cz9_id_empleado', $id)->first();

        // dd($estado);
        if (!empty($estado)) {
            $empleado = z9_empleados_info::find($id);

            if (Gate::allows('isAdmin') ||
                Gate::allows('isRRHH') || Gate::allows('isSST')) {
                $empleado->cz9_fecha_tpprueba = $request->fecha_tpprueba;
                $empleado->cz9_fecha_vacuna = $request->fecha_vacuna;
                $empleado->cz9_lugar_vacuna = $request->lugar_vacuna;
                $empleado->cz9_fecha_vacuna_tifoidea = $request->fecha_vacuna_tifoidea;
                $empleado->cz9_lugar_vacuna_tifoidea = $request->lugar_vacuna_tifoidea;
                $empleado->cz9_fecha_vacuna_toxoide = $request->fecha_vacuna_toxoide;
                $empleado->cz9_lugar_vacuna_toxoide = $request->lugar_vacuna_toxoide;
                $empleado->cz9_reentrenamiento = $request->reentrenamiento;
                $empleado->cz9_premios = $request->cz9_premios;
                $empleado->cz9_fv_ta = $request->cz9_fv_ta;
                $empleado->cz9_fv_bpm = $request->cz9_fv_bpm;
                $empleado->cz9_fv_md = $request->cz9_fv_md;
                $empleado->cz9_premios = $request->cz9_premios;
                $empleado->cz9_fv_carne_vacunacion = $request->cz9_fv_carne_vacunacion;
                $empleado->cz9_fv_carne_alimentos = $request->cz9_fv_carne_alimentos;
                $empleado->cz9_talla_uniforme = $request->talla_uni;
               

                if ($request->hasFile('file_titulacion')) {
                    $file = $request->file('file_titulacion');
                    $name = time() . $file->getClientOriginalName();
                    $file->move('theme/files/sst', $name);
                    $empleado->cz9_archivo_titulacion = time() . $file->getClientOriginalName();
                }

            }
            if ($request->hasFile('file_vacunacion')) {
                $file = $request->file('file_vacunacion');
                $name = time() . $file->getClientOriginalName();
                $file->move('theme/files/sst', $name);
                $empleado->cz9_archivo_vacunacion = time() . $file->getClientOriginalName();
            }
            $empleado->cz9_id_vivienda = $request->cz9_id_vivienda;
            $empleado->cz9_nombre_familiar = $request->familiar_linco;
            $empleado->cz9_nombre_contacto = $request->contacto;
            $empleado->cz9_tel_contacto = $request->con_num;
            // $empleado->cz9_talla_uniforme = $request->talla_uni;
            $empleado->cz9_talla_calzado = $request->talla_cal;
            $empleado->cz9_mail_corp = $request->email_corp;
            $empleado->cz9_tel_corp = $request->tel_corp;
            $empleado->cz9_cel_corp = $request->cel_corp;
            $empleado->save();

        } else {

            $empleado = new z9_empleados_info;

            if (Gate::allows('isAdmin') ||
                Gate::allows('isRRHH') || Gate::allows('isSST')) {

                $empleado->cz9_fecha_tpprueba = $request->fecha_tpprueba;
                $empleado->cz9_fecha_vacuna = $request->fecha_vacuna;
                $empleado->cz9_lugar_vacuna = $request->lugar_vacuna;
                $empleado->cz9_fecha_vacuna_tifoidea = $request->fecha_vacuna_tifoidea;
                $empleado->cz9_lugar_vacuna_tifoidea = $request->lugar_vacuna_tifoidea;
                $empleado->cz9_fecha_vacuna_toxoide = $request->fecha_vacuna_toxoide;
                $empleado->cz9_lugar_vacuna_toxoide = $request->lugar_vacuna_toxoide;
                $empleado->cz9_reentrenamiento = $request->reentrenamiento;
                $empleado->cz9_premios = $request->cz9_premios;
                $empleado->cz9_fv_ta = $request->cz9_fv_ta;
                $empleado->cz9_fv_bpm = $request->cz9_fv_bpm;
                $empleado->cz9_fv_md = $request->cz9_fv_md;
                $empleado->cz9_premios = $request->cz9_premios;
                $empleado->cz9_fv_carne_vacunacion = $request->cz9_fv_carne_vacunacion;
                $empleado->cz9_fv_carne_alimentos = $request->cz9_fv_carne_alimentos;
                $empleado->cz9_talla_uniforme = $request->talla_uni;
                
                if ($request->hasFile('file_titulacion')) {
                    $file = $request->file('file_titulacion');
                    $name = time() . $file->getClientOriginalName();
                    $file->move('theme/files/sst', $name);
                    $empleado->cz9_archivo_titulacion = time() . $file->getClientOriginalName();
                }

            }
            
            if ($request->hasFile('file_vacunacion')) {
                $file = $request->file('file_vacunacion');
                $name = time() . $file->getClientOriginalName();
                $file->move('theme/files/sst', $name);
                $empleado->cz9_archivo_vacunacion = time() . $file->getClientOriginalName();
            }
            $empleado->cz9_id_vivienda = $request->cz9_id_vivienda;
            $empleado->cz9_nombre_familiar = $request->familiar_linco;
            $empleado->cz9_nombre_contacto = $request->contacto;
            $empleado->cz9_tel_contacto = $request->con_num;
            // $empleado->cz9_talla_uniforme = $request->talla_uni;
            $empleado->cz9_talla_calzado = $request->talla_cal;
            $empleado->cz9_id_empleado = $id;
            $empleado->cz9_mail_corp = $request->email_corp;
            $empleado->cz9_tel_corp = $request->tel_corp;
            $empleado->cz9_cel_corp = $request->cel_corp;
            $empleado->save();

        }
    }
    public function guardar($id)
    {

    }

    //TRAE LOS DATOS DE LA TABLA Z9_EMPLEADOS
    public function traerEmpleadoInfo($id)
    {
        if ($id == Auth()->user()->cz1_id_empleado || Gate::allows('isAdmin') ||
            Gate::allows('isRRHH') || Gate::allows('isSST')) {
            $empleado = Terceros_mm::select(
                'cz9_nombre_familiar',
                'cz9_nombre_contacto',
                'cz9_tel_contacto',
                'cz9_fecha_tpprueba',
                'cz9_talla_uniforme',
                'cz9_talla_calzado',
                'cz9_fecha_vacuna',
                'cz9_lugar_vacuna',
                'cz9_fecha_vacuna_tifoidea',
                'cz9_lugar_vacuna_tifoidea',
                'cz9_fecha_vacuna_toxoide',
                'cz9_lugar_vacuna_toxoide',
                'cz9_reentrenamiento',
                'cz9_mail_corp',
                'cz9_tel_corp',
                'cz9_cel_corp',
                'cz9_fv_ta',
                'cz9_fv_bpm',
                'cz9_fv_md',
                'cz9_fv_carne_vacunacion',
                'cz9_fv_carne_alimentos',
                'cz9_archivo_titulacion',
                'cz9_archivo_vacunacion',
                'cz9_id_vivienda'
                ,'c0780_descripcion',
                'cz9_premios'




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
                'dbo.w0540_empleados.c0540_rowid_prospecto',
                '=',
                'dbo.w0541_terceros_seleccion.c0541_rowid'
                

            )
            ->leftjoin(
                'w0780_gh01_clase_social',
                'w0541_terceros_seleccion.c0541_rowid_clases_sociales',
                '=',
                'w0780_gh01_clase_social.c0780_rowid'

            )
            ->join(
                'dbo.w0550_contratos',
                'dbo.w0540_empleados.c0540_rowid_tercero',
                '=',
                'dbo.w0550_contratos.c0550_rowid_tercero'

            )->join(
                'dbo.z9_empleados_info',
                'dbo.w0540_empleados.c0540_rowid_tercero',
                '=',
                'dbo.z9_empleados_info.cz9_id_empleado')
                ->where('dbo.t200_mm_terceros.f200_rowid', $id)
                ->first();

            return $empleado;
        }else{
            return redirect('/accces-denied');   
        }  
    }

    //TRAE TODO LO RELACIONADO CON EL CONTRATO Y EL EMPLEADO

    public function traerEmpleados($id)
    {
        if ($id == Auth()->user()->cz1_id_empleado || Gate::allows('isAdmin') ||
            Gate::allows('isRRHH') || Gate::allows('isSST')) {

            $estado = 1;
            $contratoV = Contrato::find($id)->where('c0550_ind_estado', 2)->first();

            $contratoA = Contrato::where('c0550_rowid_tercero', $id)->where('c0550_ind_estado', 1)->first();
            if (empty($contratoA)) {
                $estado = 2;
            };

            $id_depto = Empleados::select("c0540_id_depto_exp_identif")
                ->where("c0540_rowid_tercero", $id)->first();

            //  return Paises::with('departamentos')->get();
            $user = Terceros_mm::select(
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
                'c0550_rowid',
                'c0550_salario',
                "c0540_id_ciudad_nacimiento",
                "c0540_id_ciudad_exp_identif",
                "c0540_id_depto_exp_identif",
                "c0540_id_pais_exp_identif",
                "f285_descripcion",
                "c0540_fecha_nacimiento",
                "c0550_ind_termino_contrato"

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
                'dbo.t285_co_centro_op',
                'dbo.w0550_contratos.c0550_id_co',
                '=',
                'dbo.t285_co_centro_op.f285_id'

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
            )
                ->join(
                    'dbo.t013_mm_ciudades',
                    'dbo.w0540_empleados.c0540_id_ciudad_exp_identif',
                    '=',
                    'dbo.t013_mm_ciudades.f013_id'
                )
                ->join(
                    'dbo.t012_mm_deptos',
                    'dbo.w0540_empleados.c0540_id_depto_exp_identif',
                    '=',
                    'dbo.t012_mm_deptos.f012_id'
                )
                ->join(
                    'dbo.t011_mm_paises',
                    'dbo.w0540_empleados.c0540_id_pais_exp_identif',
                    '=',
                    'dbo.t011_mm_paises.f011_id'
                )

                ->where('c0550_ind_estado', $estado)
                ->where('f200_rowid', $id)
                ->where('f013_id_depto', $id_depto->c0540_id_depto_exp_identif)
                ->get();

                $results = $user->last();

            return $results;

        }else{
            return redirect('/accces-denied');   
        }  
    }

}
