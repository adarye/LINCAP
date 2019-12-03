<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\z2_roles;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request){    
        return z2_roles::all();      
    }

    public function show($id){       
          return z2_roles::where('cz2_id', $id)->get();
    }

    public function update(Request $request, $cz2_id){
        $rol = z2_roles::find($cz2_id);
        $rol->cz2_nombre = $request->nombre;
        $rol->cz2_descripcion = $request->descripcion;
        $rol->save();
        return $rol;
    }
    public function create(Request $request){
        $rol = new z2_roles();
        $rol->cz2_nombre = $request->nombre;
        $rol->cz2_descripcion = $request->descripcion;
        $rol->save();

        
    
        return $rol;     
        
    }
    public function delete($id)
{
    $rol = z2_roles::find($id);
    $rol->delete();
}
}
