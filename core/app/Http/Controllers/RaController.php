<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\z6_rta_ra;

class RaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function guardar(Request $request){
       $ra = new z6_rta_ra();
       $ra->cz6_pp_id = $request->id;
       $ra->save();

       return $ra;
    }
    
}
