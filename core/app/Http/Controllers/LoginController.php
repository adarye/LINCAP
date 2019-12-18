<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Terceros_mm;
use Illuminate\Support\Facades\Auth;
use View;

class LoginController extends Controller
{
    public $nombre;

    public function iniciarSesion(LoginFormRequest $request)
    {      
        if (Auth::attempt(['cz1_cc' => $request->cz1_cc, 'password' => $request->cz1_contrasena], false)) {

            $estado = Terceros_mm::select(
                'c0550_ind_estado',
                 "f200_nombres"
            )->join(
                'dbo.t200_mm_terceros',
                'dbo.t015_mm_contactos.f015_rowid',
                '=',
                'dbo.t200_mm_terceros.f200_rowid_contacto'
            )->join(
                'dbo.w0550_contratos', 'dbo.t200_mm_terceros.f200_rowid',
                '=', 'dbo.w0550_contratos.c0550_rowid_tercero'
            )
            ->where('f200_rowid', Auth()->user()->cz1_id_empleado)
            ->where('c0550_ind_estado', '1')->first();

            if ($estado == null) {
                Auth::logout();
                return 'inactivo';
            } else {                
                return response()->json(Auth::user(), 200);
            }

        } else {
            return response()->json(['errors' => ['login' => ['Datos incorrectos']]], 422);
        }

    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
   

}
