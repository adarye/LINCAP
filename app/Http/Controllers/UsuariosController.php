<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\z1_usuarios;

class UsuariosController extends Controller
{
    public function index(){
        return z1_usuarios::select(
            'cz2_nombre',
            'c0541_nombres',
            'c0541_apellido1',
            'c0541_apellido2',
            'cz1_cc'

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
}
