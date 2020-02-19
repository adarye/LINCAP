<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudades extends Model
{
    protected $table = 'dbo.t013_mm_ciudades';

    public function departamento(){
        return $this->belongsTo('App\departamentos');
   }
}
