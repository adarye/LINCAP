<?php

namespace App\Http\Controllers;

use App\z3_gestion_pruebas;
use App\z4_rel_ts_gp;
use App\z5_prueba_preguntas;
use App\z11_resultados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EstadisticasController extends Controller
{
    public  function buscarSMUR($id){
        return z11_resultados::where('cz11_rta', $id)->count();

    }
}
