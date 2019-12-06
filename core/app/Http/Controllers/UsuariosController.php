<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\z1_usuarios;

class UsuariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        
        return z1_usuarios::select(
            'cz2_nombre',
            'c0541_nombres',
            'c0541_apellido1',
            'c0541_apellido2',
            'cz1_cc',
            'c0541_rowid',
            'cz1_id',
            'cz1_estado',
            'password'

        )->join(
            'z2_roles',
            'z1_usuarios.cz1_id_rol',
            '=',
            'z2_roles.cz2_id'       
        )->join(
            'dbo.w0540_empleados',
            'z1_usuarios.cz1_id_empleado',
            '=',
            'dbo.w0540_empleados.c0540_rowid_tercero'
        )->join(
            'dbo.w0541_terceros_seleccion',
            'dbo.w0540_empleados.c0540_rowid_prospecto',
            '=',
            'dbo.w0541_terceros_seleccion.c0541_rowid'
        )->get();
        
        
    }
    public function create(Request $request){
        $usuario = new z1_usuarios();
        $usuario->cz1_cc = $request->cz1_cc;
        $usuario->password = bcrypt($request->cz1_password);
        $usuario->cz1_id_rol = $request->cz1_id_rol;
        $usuario->cz1_id_empleado = $request->cz1_id_empleado;
        $usuario->cz1_avatar = 'prueba';
        $usuario->cz1_estado = 1;
        $usuario->save();       
    
    }
    public function delete($id){
        $usuario = z1_usuarios::find($id);
         $usuario->delete();
    }


    public function update(Request $request, $cz1_id){

        $usuario = z1_usuarios::find($cz1_id);
        $usuario->password = $request->cz1_password;
        $usuario->cz1_id_rol = $request->cz1_id_rol;
        $usuario->cz1_estado = $request->cz1_estado;
        $usuario->save();
        return $usuario;
        
    }
}
