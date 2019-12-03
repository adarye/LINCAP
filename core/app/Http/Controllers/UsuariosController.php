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
            'dbo.w0541_terceros_seleccion',
            'z1_usuarios.cz1_ts_id',
            '=',
            'dbo.w0541_terceros_seleccion.c0541_rowid'
        )->get();
        
    }
    public function buscarTercero(){
        return cz2_usuarios::where();

    }
    public function create(Request $request){
        $usuario = new z1_usuarios();
        $usuario->cz1_cc = $request->cz1_cc;
        $usuario->password = bcrypt($request->cz1_password);
        $usuario->cz1_id_rol = $request->cz1_id_rol;
        $usuario->cz1_ts_id = $request->cz1_ts_id;
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
