<?php

namespace App\Http\Controllers;

use App\Mail\AsignacionPrueba;
use App\Terceros_mm;
use App\z1_usuarios;
use App\z3_gestion_pruebas;
use App\z4_rel_ts_gp;
use App\z11_resultados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AsignacionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function guardar(Request $request)
    {
        if (Gate::allows('isAdmin') ||
            Gate::allows('isRRHH') || Gate::allows('isSST') || Gate::allows('isJefe')) {
            //ELIMINAMOS CUALQUIER PRUEBA DUPLICADA
            // $prueba = z4_rel_ts_gp::where('cz4_ts_id', $request->id)->where('cz4_gp_id', $request->id_prueba)->first();
            // $prueba->delete();

            $relacion = new z4_rel_ts_gp;
            $relacion->cz4_gp_id = $request->id_prueba;
            $relacion->cz4_ts_id = $request->id;
            $relacion->cz4_estado = 0;
            $relacion->save();

            $user_email = z1_usuarios::select('cz1_nombres', 'f015_email', 'cz1_cc')
                ->join(
                    'dbo.t200_mm_terceros',
                    'dbo.z1_usuarios.cz1_id_empleado',
                    '=',
                    'dbo.t200_mm_terceros.f200_rowid'
                )->join(
                'dbo.t015_mm_contactos',
                'dbo.t200_mm_terceros.f200_rowid_contacto',
                '=',
                'dbo.t015_mm_contactos.f015_rowid'
            )
                ->where('dbo.z1_usuarios.cz1_id_empleado', $request->id)
                ->first();

            if ($user_email->f015_email == null) {
                return response()->json(['error' => '', 'mensaje' => 'No tiene un correo electrónico registrado']);
            } else {
                $prueba = z3_gestion_pruebas::select(
                    'cz3_nombre',
                    'cz3_descripcion',
                    'cz3_fecha_apertura',
                    'cz3_fecha_cierre',
                    'f200_nombres',
                    'f200_apellido1',
                    'f200_apellido2',
                    'cz3_categoria'
                    )
                    ->join(
                    'dbo.t200_mm_terceros',
                    'dbo.z3_gestion_pruebas.cz3_id_creador',
                    '=',
                    'dbo.t200_mm_terceros.f200_rowid')
                    ->where('cz3_id', $request->id_prueba)
                    ->first();
                Mail::to($user_email->f015_email)->send(new AsignacionPrueba($user_email, $prueba));
                return response()->json(['error' => '', 'mensaje' => 'Se le ha enviado un email a ' . ' '. $user_email->f015_email] );
            }
        }
    }
    public function delete(Request $request)
    {
        //return $request->seleccionados;
        if (Gate::allows('isAdmin') ||
            Gate::allows('isRRHH') || Gate::allows('isSST') || Gate::allows('isJefe')) {
            $prueba = z4_rel_ts_gp::where('cz4_ts_id', $request->id_ts)->where('cz4_gp_id', $request->id_prueba)->first();
            $prueba->delete();
            $respuestas = z11_resultados::where('cz11_id_empleado', $request->id_ts)->where('cz11_id_gp', $request->id_prueba)->delete();

        }
    }
    public function index($id)
    {
        if (Gate::allows('isAdmin') ||
            Gate::allows('isRRHH') || Gate::allows('isSST') || Gate::allows('isJefe')) {
            $registros = z4_rel_ts_gp::select('cz4_ts_id', 'cz4_calificacion')->where('cz4_gp_id', $id)->get();
            $j = json_decode($registros, true);
            return $registros;
        }
    }
    public function guardarTodos(Request $request)
    {
        if (Gate::allows('isAdmin') ||
            Gate::allows('isRRHH') || Gate::allows('isSST') || Gate::allows('isJefe') ) {
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
        if (Gate::allows('isAdmin') ||
            Gate::allows('isRRHH') || Gate::allows('isSST') || Gate::allows('isJefe')) {
            $todos = (array) $request->activos;
            $i = 0;

            foreach ($todos as $req) {
                $a = $todos[$i];
                $all = z4_rel_ts_gp::where('cz4_ts_id', $a['c0550_rowid_tercero'])
                    ->where('cz4_gp_id', $request->id_prueba)
                    ->first();
                if ($all != null) {
                    $all->delete();
                    $respuestas = z11_resultados::where('cz11_id_gp', $request->id_prueba)->delete();
                }
                $i++;

            }
        }

    }
    public function finalizarPrueba($id)
    {
      

        $prueba = z4_rel_ts_gp::where('cz4_ts_id', Auth()->user()->cz1_id_empleado)->where('cz4_gp_id', $id)->first();
        $prueba->cz4_estado = 2;
        $prueba->cz4_fecha_finalizacion = Carbon::now();

        $prueba->save();
    }

    public function contar($id)
    {
        return z4_rel_ts_gp::where('cz4_gp_id', $id)->count();
    }

    public function conseguirEstado($id, $empleado)
    {
        return z4_rel_ts_gp::select('cz4_id', 'cz4_estado', 'cz4_calificacion')->where('cz4_ts_id', $empleado)
            ->where('cz4_gp_id', $id)->first();
    }

    public function conseguirNota($id)
    {
        if (Gate::allows('isAdmin') ||
            Gate::allows('isRRHH') || Gate::allows('isSST') || Gate::allows('isJefe') ) {

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
            "f200_rowid"

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
            ->where('c0550_ind_estado', '1')
            ->orderBy('c0541_nombres', 'ASC')
            ->with(array('nota' => function ($query) use ($id) {
                $query->select()->where('cz4_gp_id', $id);
            }))
            ->get();
        }

    }

}
