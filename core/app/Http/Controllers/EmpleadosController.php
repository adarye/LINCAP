<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Empleados;

class EmpleadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function obtenerTercero($id){
        //return $id;
       return Empleados::select('c0540_rowid_tercero')->where('c0540_rowid_prospecto', '=', $id)->first();
    }
   
}
