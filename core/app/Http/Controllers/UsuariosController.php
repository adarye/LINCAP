<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\PasswordReset;
use App\z1_usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UsuariosController extends Controller
{
    public $global;
    public function __construct()
    {
        $this->middleware('auth')->except(['enviarEmail', 'validarToken', 'resetPassword']);
    }
    public function index()
    {

        return z1_usuarios::select(
            'cz2_nombre',
            'cz1_cc',
            'cz1_id',
            'cz1_estado',           
             'cz1_nombres',
             'cz1_id_rol'

        )->join(
            'z2_roles',
            'z1_usuarios.cz1_id_rol',
            '=',
            'z2_roles.cz2_id'
        )->get();

    }
    public function create(Request $request)
    {
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
    public function delete($id)
    {
        $usuario = z1_usuarios::find($id);
        $usuario->delete();
    }

    public function update(Request $request, $cz1_id)
    {

        $usuario = z1_usuarios::find($cz1_id);
        $usuario->password = $request->cz1_password;
        $usuario->cz1_id_rol = $request->cz1_id_rol;
        $usuario->save();
        return $usuario;

    }
    public function myAvatar(Request $request, $id)
    {

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $name = time() . $file->getClientOriginalName();
            $file->move('theme/images/profile', $name);

            return z1_usuarios::select('cz1_id_empleado', 'cz1_avatar')
                ->where('cz1_id_empleado', $id)
                ->update([
                    'cz1_avatar' => $name,
                ]);

        }
        //return $request->imagen;

    }
    public function cambiarPassword(Request $request)
    {

        $usuario = z1_usuarios::all()
            ->where('cz1_id', Auth()->user()->cz1_id)->first();

        if (Hash::check($request->password_anterior, $usuario->password)) {
            $password = z1_usuarios::find(Auth()->user()->cz1_id);
            $password->password = bcrypt($request->password_nueva);
            $password->save();
            Auth::logout();
            return 1;
        } else {
            Auth::logout();
            return 0;

        };

    }
    public function enviarEmail(Request $request)
    {
        //return $request->cedula;
        $validacion = z1_usuarios::where('cz1_cc', $request->cedula)->first();
        if ($validacion != null) {
            $this->global = z1_usuarios::select('cz1_nombres', 'f015_email', 'cz1_cc')
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
                ->where('dbo.z1_usuarios.cz1_cc', $request->cedula)
                ->get();
        }

        if ($this->global == null) {
            return response()->json(['error' => 'No estas registrado en el sistema', 'mensaje' => '']);
        } else if ($this->global[0]->f015_email == null) {
            return response()->json(['error' => 'No tiene un correo registrado', 'mensaje' => '']);
        } else {
            //ElIMINAMOS TODOS LOS TOKEN QUE TENGA ESE CORREO

            PasswordReset::where('cedula', $request->cedula)->delete();

            //GENERAMOS EL TOKEN Y LO ENVIAMOS AL CORREO

            $token = Str::random(40);
            Mail::to($this->global[0]->f015_email)->send(new ResetPassword($token));

            //GUARDAMOS EL TOKEN EN SU TABLA

            $PaswordReset = new PasswordReset();
            $PaswordReset->cedula = $this->global[0]->cz1_cc;
            $PaswordReset->token = $token;
            $PaswordReset->save();

            return response()->json(['mensaje' => 'Se envio un token a tu correo', 'correo' => $this->global[0]->f015_email, 'error' => ''], 200);
        }

    }

    public function validarToken(Request $request)
    {
        $PasswordReset = PasswordReset::where('token', $request->token)->first();
        if ($PasswordReset == null) {
            return response()->json(['error' => 'Token Invalido']);
        }
        $usuario = z1_usuarios::where('cz1_cc', $PasswordReset->cedula)->first();
        return response()->json(['error' => '', 'usuario' => $usuario]);

    }

    public function resetPassword(Request $request)
    {
        $usuario = z1_usuarios::where('cz1_cc', $request->cedula)->first();

        $PasswordReset = PasswordReset::where('cedula', $usuario->cz1_cc)->first();
        $PasswordReset->delete();

        $usuario->password = bcrypt($request->password);
        $usuario->save();

    }

}
