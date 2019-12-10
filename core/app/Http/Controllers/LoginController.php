<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Terceros_mm;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function iniciarSesion(LoginFormRequest $request)
    {

        //return response()->json($request->all(),200);

        if (Auth::attempt(['cz1_cc' => $request->cz1_cc, 'password' => $request->cz1_contrasena], false)) {

            $estado = Terceros_mm::select(
                'c0550_ind_estado'
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
                //return redirect('/login');
                return 'inactivo';
            }else{

            return response()->json(Auth::user(), 200);
            }

        } else {
            return response()->json(['errors' => ['login' => ['Los datos que ingresastes son incorrectos']]], 422);
        }

    }
    public function logout()
    {

        Auth::logout();

        return redirect('/login');
    }

}
