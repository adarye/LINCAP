<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\z2_roles;

use Illuminate\Support\Facades\Gate;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request){
        if (Gate::allows('isAdmin')) {    
        return z2_roles::all();
        }      
    }

    public function show($id){   
        if (Gate::allows('isAdmin')) {    
          return z2_roles::where('cz2_id', $id)->get();
        }
    }

    public function update(Request $request, $cz2_id){
        if (Gate::allows('isAdmin')) {
        $rol = z2_roles::find($cz2_id);
        $rol->cz2_nombre = $request->nombre;
        $rol->cz2_descripcion = $request->descripcion;
        $rol->save();
        return $rol;
        }
    }
    public function create(Request $request){
        if (Gate::allows('isAdmin')) {
        $rol = new z2_roles();
        $rol->cz2_nombre = $request->nombre;
        $rol->cz2_descripcion = $request->descripcion;
        $rol->save();

        
    
        return $rol;     
        }
        
    }
    public function delete($id)
{
    if (Gate::allows('isAdmin')) {
    $rol = z2_roles::find($id);
    $rol->delete();
    }
}
}
