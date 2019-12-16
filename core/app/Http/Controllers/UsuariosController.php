<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

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
        $usuario->cz1_nombres = $request->cz1_nombres;
        $usuario->cz1_avatar = 'user.png';
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
        $usuario->save();
        return $usuario;
        
    }
    public function myAvatar(Request $request,$id)
{    
      
    if($request->hasFile('imagen')){
        $file = $request->file('imagen');
        $name = time().$file->getClientOriginalName();
        $file->move('theme/images/profile', $name);

       
         return z1_usuarios::select('cz1_id_empleado', 'cz1_avatar')
        ->where('cz1_id_empleado', $id)
        ->update([
           'cz1_avatar'=>$name
        ]);

    } 
        //return $request->imagen;
    
}
public function cambiarPassword(Request $request){
    
    
   $usuario = z1_usuarios::all()
    ->where('cz1_id', Auth()->user()->cz1_id)->first();
   
    
    if(Hash::check($request->password_anterior, $usuario->password)){
        $password = z1_usuarios::find(Auth()->user()->cz1_id);
        $password->password = bcrypt($request->password_nueva);
        $password->save();
        Auth::logout();
        return 1;
    }
    else{
        Auth::logout();
        return 0;
       
    };

   

    //$usuario = z1_usuarios::find(Auth()->user()->cz1_id);
    
}
}
