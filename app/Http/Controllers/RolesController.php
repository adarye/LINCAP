<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\z2_roles;

class RolesController extends Controller
{
    public function index(Request $request){
    
        return z2_roles::all();
      
    }
    public function show($id){

       
          return z2_roles::where('cz2_id', $id)->get();
    }
}
