<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Usuario;

class LoginController extends Controller
{

public function iniciarSesion(LoginFormRequest $request){
   
    //return response()->json($request->all(),200);

    if(Auth::attempt(['cz1_cc' => $request->cz1_cc, 'password' => $request->cz1_contrasena],false)){   
        return response()->json(Auth::user(), 200);
    }
    else{
        return response()->json(['errors' =>['login' =>['Los datos que ingresastes son incorrectos']]],422);
    }

}
public function logout(){

    Auth::logout();

    return redirect('/login');
}
    
    
}
