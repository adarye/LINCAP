<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use Illuminate\Http\Request;
use Auth;
use App\Usuario;

class LoginController extends Controller
{

public function iniciarSesion(LoginFormRequest $request){
   
    //return response()->json($request->all(),200);

    if(Auth::attempt(['cz1_cc' => $request->cz1_cc, 'password' => $request->cz1_contrasena],false)){
        return response()->json('Ha iniciado sesion',200);
    }
    else{
        return response()->json(['errors' =>['login' =>['Los datos que ingresastes son incorrectos']]],422);
    }


}
    
    
}
