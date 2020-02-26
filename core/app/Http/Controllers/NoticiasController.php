<?php

namespace App\Http\Controllers;

use App\z12_noticias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
class NoticiasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function guardar(Request $request)
    {
        
        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') || Gate::allows('isJefe')) {
        $noticia = new z12_noticias;
        $noticia->cz12_nombre = $request->nombre;
        $noticia->cz12_descripcion = $request->descripcion;
        $noticia->cz12_nivel_imp = $request->importancia;
        $noticia->cz12_id_empleado = Auth()->user()->cz1_id_empleado;
         $fecha = Carbon::now();
          $noticia->cz12_fecha_creacion = $fecha->format('Y-m-d H:i');
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $name = time() . $file->getClientOriginalName();
            $file->move('theme/images/noticias', $name);
            $noticia->cz12_imagen = time() . $file->getClientOriginalName();
        }
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $name = time() . $file->getClientOriginalName();
            $file->move('theme/files/noticias', $name);
            $noticia->cz12_archivo = time() . $file->getClientOriginalName();
        }
        $noticia->save();
        return $noticia;
    }
    }
    public function index()
    {
        return z12_noticias::select('cz12_id', 'cz12_nombre', 'cz12_descripcion',
            'cz12_imagen', 'cz12_nivel_imp', 'cz12_archivo', 'cz12_id_empleado', 'z12_noticias.created_at', 'cz1_nombres', 'cz12_fecha_creacion', 'cz1_avatar')
            ->join(
                'dbo.w0540_empleados',
                'z12_noticias.cz12_id_empleado',
                '=',
                'dbo.w0540_empleados.c0540_rowid_tercero'
            )->join(
            'dbo.z1_usuarios',
            'dbo.w0540_empleados.c0540_rowid_tercero',
            '=',
            'dbo.z1_usuarios.cz1_id_empleado'
        )
            ->orderBy('z12_noticias.cz12_nivel_imp', 'desc')
            ->orderBy('z12_noticias.created_at', 'desc')
            ->get();
    }
    public function delete($id)
    {
        if(Gate::allows('isAdmin') || 
        Gate::allows('isRRHH') || Gate::allows('isSST') || Gate::allows('isJefe')) {
        $noticia = z12_noticias::find($id);
        $noticia->delete();
        return $noticia;
        }

    }
    public function actualizar(Request $request)
    {
    //    return $request;
    if(Gate::allows('isAdmin') || 
    Gate::allows('isRRHH') || Gate::allows('isSST') || Gate::allows('isJefe')) {
        $noticia =  z12_noticias::find($request->id);
        $noticia->cz12_nombre = $request->nombre;
        $noticia->cz12_descripcion = $request->descripcion;
        $noticia->cz12_nivel_imp = $request->importancia;
        $noticia->cz12_id_empleado = Auth()->user()->cz1_id_empleado;
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $name = time() . $file->getClientOriginalName();
            $file->move('theme/images/noticias', $name);
            $noticia->cz12_imagen = time() . $file->getClientOriginalName();
        }
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $name = time() . $file->getClientOriginalName();
            $file->move('theme/files/noticias', $name);
            $noticia->cz12_archivo = time() . $file->getClientOriginalName();
        }
        $noticia->save();
        return $noticia;
    }
}
public function descargar($id){
    return response()->download('theme/files/noticias/'.$id);
}
}
